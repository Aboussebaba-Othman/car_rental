<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Show the document upload form.
     *
     * @return \Illuminate\View\View
     */
    public function showUploadForm()
    {
        $company = Auth::user()->company;
        return view('company.documents.upload', compact('company'));
    }

    /**
     * Process the document uploads.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'registre_commerce' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'carte_fiscale' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'cnas_casnos' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'autorisation_exploitation' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'contrat_location' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'assurance_entreprise' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ]);

        $company = Auth::user()->company;
        
        // Process and store each document
        $documents = [];
        
        foreach ($request->file() as $key => $file) {
            $path = $file->store('company_documents/' . $company->id, 'public');
            $documents[$key] = $path;
        }
        
        // Update company with JSON document paths
        $company->legal_documents = json_encode($documents);
        $company->save();

        return redirect()->route('company.dashboard')
            ->with('success', 'All documents have been uploaded successfully. Your account is now pending admin verification.');
    }
}