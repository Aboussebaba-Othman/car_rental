<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehiclePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VehicleController extends Controller
{
    /**
     * Display a listing of the vehicles.
     */
    public function index()
    {
        $company = Auth::user()->company;
        $vehicles = Vehicle::where('company_id', $company->id)
                        ->with('photos')
                        ->latest()
                        ->paginate(10);

        return view('company.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        return view('company.vehicles.create');
    }

    /**
     * Store a newly created vehicle in storage.
     */
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
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create vehicle
        $vehicle = new Vehicle();
        $vehicle->company_id = Auth::user()->company->id;
        $vehicle->brand = $validated['brand'];
        $vehicle->model = $validated['model'];
        $vehicle->year = $validated['year'];
        $vehicle->license_plate = $validated['license_plate'];
        $vehicle->transmission = $validated['transmission'];
        $vehicle->fuel_type = $validated['fuel_type'];
        $vehicle->seats = $validated['seats'];
        $vehicle->price_per_day = $validated['price_per_day'];
        $vehicle->description = $validated['description'] ?? null;
        $vehicle->features = $validated['features'] ?? null;
        $vehicle->is_active = true;
        $vehicle->is_available = true;
        $vehicle->save();

        // Handle photos upload
        if ($request->hasFile('photos')) {
            $photos = $request->file('photos');
            $displayOrder = 1;
            
            foreach ($photos as $photo) {
                $path = $photo->store('vehicles/' . $vehicle->id, 'public');
                
                $vehiclePhoto = new VehiclePhoto();
                $vehiclePhoto->vehicle_id = $vehicle->id;
                $vehiclePhoto->path = $path;
                $vehiclePhoto->is_primary = ($displayOrder === 1); // First photo is primary
                $vehiclePhoto->display_order = $displayOrder++;
                $vehiclePhoto->save();
            }
        }

        return redirect()->route('company.vehicles.index')
            ->with('success', 'Vehicle added successfully.');
    }

    /**
     * Display the specified vehicle.
     */
    public function show(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        return view('company.vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        return view('company.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
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

        // Update vehicle
        $vehicle->brand = $validated['brand'];
        $vehicle->model = $validated['model'];
        $vehicle->year = $validated['year'];
        $vehicle->license_plate = $validated['license_plate'];
        $vehicle->transmission = $validated['transmission'];
        $vehicle->fuel_type = $validated['fuel_type'];
        $vehicle->seats = $validated['seats'];
        $vehicle->price_per_day = $validated['price_per_day'];
        $vehicle->description = $validated['description'] ?? null;
        $vehicle->features = $validated['features'] ?? null;
        $vehicle->is_active = $request->has('is_active');
        $vehicle->is_available = $request->has('is_available');
        $vehicle->save();

        // Delete photos if requested
        if ($request->has('photos_to_delete') && is_array($request->photos_to_delete)) {
            foreach ($request->photos_to_delete as $photoId) {
                $photo = VehiclePhoto::find($photoId);
                if ($photo && $photo->vehicle_id == $vehicle->id) {
                    // Delete file from storage
                    if (Storage::disk('public')->exists($photo->path)) {
                        Storage::disk('public')->delete($photo->path);
                    }
                    $photo->delete();
                }
            }
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
            $primaryPhotoId = $request->input('primary_photo_id');
            
            // Reset all photos to non-primary
            VehiclePhoto::where('vehicle_id', $vehicle->id)
                ->update(['is_primary' => false]);
            
            // Set the selected photo as primary
            VehiclePhoto::where('id', $primaryPhotoId)
                ->where('vehicle_id', $vehicle->id)
                ->update(['is_primary' => true]);
        }

        return redirect()->route('company.vehicles.index')
            ->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
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
        $vehicle->delete();

        return redirect()->route('company.vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
    }

    /**
     * Toggle vehicle active status.
     */
    public function toggleActive(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        
        $vehicle->is_active = !$vehicle->is_active;
        $vehicle->save();

        return redirect()->route('company.vehicles.index')
            ->with('success', 'Vehicle status updated successfully.');
    }

    /**
     * Toggle vehicle availability.
     */
    public function toggleAvailability(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        
        $vehicle->is_available = !$vehicle->is_available;
        $vehicle->save();

        return redirect()->route('company.vehicles.index')
            ->with('success', 'Vehicle availability updated successfully.');
    }

    /**
     * Check if the authenticated company owns the vehicle.
     */
    private function authorizeVehicle(Vehicle $vehicle)
    {
        if ($vehicle->company_id !== Auth::user()->company->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}