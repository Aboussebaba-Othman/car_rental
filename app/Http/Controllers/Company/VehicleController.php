<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehiclePhoto;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
   
    private $vehicleRepository;
    
    public function __construct(VehicleRepositoryInterface $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function index()
    {
        $company = Auth::user()->company;
        $vehicles = $this->vehicleRepository->getAllForCompany($company->id);

        $vehicles = Vehicle::with(['photos', 'reservations'])
        ->where('company_id', Auth::user()->company->id)
        ->withCount('reservations')
        ->paginate(10);

        // Récupérer les marques uniques pour le filtre
        $uniqueBrands = Vehicle::where('company_id', Auth::user()->company->id)
            ->select('brand')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');
        

        return view('company.vehicles.index', compact('vehicles', 'uniqueBrands'));
    }

    public function create()
    {
        return view('company.vehicles.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'brand' => 'required|string|max:255',
        'model' => 'required|string|max:255',
        'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        'license_plate' => 'required|string|max:20|unique:vehicles',
        'transmission' => 'required|in:automatic,manual',
        'fuel_type' => 'required|in:gasoline,diesel,electric,hybrid',
        'seats' => 'required|integer|min:1|max:50',
        'price_per_day' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'features' => 'nullable|array',
        'photos' => 'nullable|array',
        'photos.*' => 'image|mimes:jpeg,png,jpg,gif',
    ]);

    // Create vehicle with repository
    $vehicleData = array_merge($validated, [
        'company_id' => Auth::user()->company->id,
        'is_active' => true,
        'is_available' => true
    ]);
    
    $vehicle = $this->vehicleRepository->create($vehicleData);

    // Handle photos upload
    if ($request->hasFile('photos')) {
        $photos = $request->file('photos');
        $displayOrder = 1;
        
        foreach ($photos as $photo) {
            $path = $photo->store('vehicles/' . $vehicle->id, 'public');
            
            VehiclePhoto::create([
                'vehicle_id' => $vehicle->id,
                'path' => $path,
                'is_primary' => ($displayOrder === 1), 
                'display_order' => $displayOrder++
            ]);
        }
    }

    return redirect()->route('company.vehicles.index')
        ->with('success', 'Véhicule ajouté avec succès.');
}

    public function show($id)
    {
        $vehicle = $this->vehicleRepository->findWithRelations($id);
        $this->authorizeVehicle($vehicle);
        
        return view('company.vehicles.show', compact('vehicle'));
    }

    public function edit($id)
    {
        $vehicle = $this->vehicleRepository->findWithRelations($id);
        $this->authorizeVehicle($vehicle);
        
        return view('company.vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, $id)
    {
        $vehicle = $this->vehicleRepository->find($id);
        $this->authorizeVehicle($vehicle);

        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'license_plate' => 'required|string|max:20|unique:vehicles,license_plate,' . $vehicle->id,
            'transmission' => 'required|in:automatic,manual',
            'fuel_type' => 'required|in:gasoline,diesel,electric,hybrid',
            'seats' => 'required|integer|min:1|max:50',
            'price_per_day' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'is_available' => 'boolean',
            'new_photos' => 'nullable|array',
            'new_photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'photos_to_delete' => 'nullable|array',
            'photos_to_delete.*' => 'integer|exists:vehicle_photos,id',
            'primary_photo_id' => 'nullable|integer|exists:vehicle_photos,id',
        ]);

        // Update vehicle data
        $vehicleData = [
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'license_plate' => $validated['license_plate'],
            'transmission' => $validated['transmission'],
            'fuel_type' => $validated['fuel_type'],
            'seats' => $validated['seats'],
            'price_per_day' => $validated['price_per_day'],
            'description' => $validated['description'] ?? null,
            'features' => $validated['features'] ?? null,
            'is_active' => $request->has('is_active'),
            'is_available' => $request->has('is_available'),
        ];
        
        $this->vehicleRepository->update($id, $vehicleData);

        // Delete photos if requested
        if ($request->has('photos_to_delete') && is_array($request->photos_to_delete)) {
            $this->vehicleRepository->deletePhotos($vehicle->id, $request->photos_to_delete);
        }

        // Add new photos if uploaded
        if ($request->hasFile('new_photos')) {
            $newPhotos = $request->file('new_photos');
            $displayOrder = $vehicle->photos()->max('display_order') + 1;
            
            foreach ($newPhotos as $photo) {
                $path = $photo->store('vehicles/' . $vehicle->id, 'public');
                
                $vehiclePhoto = new VehiclePhoto();
                $vehiclePhoto->vehicle_id = $vehicle->id;
                $vehiclePhoto->path = $path;
                $vehiclePhoto->is_primary = false; // New photos are not primary by default
                $vehiclePhoto->display_order = $displayOrder++;
                $vehiclePhoto->save();
            }
        }

        // Update primary photo if requested
        if ($request->has('primary_photo_id')) {
            $this->vehicleRepository->setPrimaryPhoto($vehicle->id, $request->input('primary_photo_id'));
        }

        return redirect()->route('company.vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    public function destroy($id)
    {
        $vehicle = $this->vehicleRepository->findWithRelations($id);
        $this->authorizeVehicle($vehicle);

        // Check if vehicle has reservations
        if ($vehicle->reservations()->exists()) {
            return redirect()->route('company.vehicles.index')
                ->with('error', 'Cannot delete vehicle with existing reservations.');
        }

        // Delete vehicle photos from storage
        foreach ($vehicle->photos as $photo) {
            if (Storage::disk('public')->exists($photo->path)) {
                Storage::disk('public')->delete($photo->path);
            }
        }

        // Delete vehicle and related photos (via foreign key constraint)
        $this->vehicleRepository->delete($id);

        return redirect()->route('company.vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }

    public function toggleActive($id)
    {
        $vehicle = $this->vehicleRepository->find($id);
        $this->authorizeVehicle($vehicle);
        
        $this->vehicleRepository->update($id, [
            'is_active' => !$vehicle->is_active
        ]);

        return redirect()->route('company.vehicles.index')
            ->with('success', 'Vehicle status updated successfully.');
    }

    public function toggleAvailability($id)
    {
        $vehicle = $this->vehicleRepository->find($id);
        $this->authorizeVehicle($vehicle);
        
        $this->vehicleRepository->update($id, [
            'is_available' => !$vehicle->is_available
        ]);

        return redirect()->route('company.vehicles.index')
            ->with('success', 'Vehicle availability updated successfully.');
    }

    private function authorizeVehicle($vehicle)
    {
        if ($vehicle->company_id !== Auth::user()->company->id) {
            abort(403, 'Unauthorized action.');
        }
        
        return true;
    }
}