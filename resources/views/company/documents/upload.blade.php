@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
            <div class="p-6 bg-gray-50 border-b border-gray-200">
                <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Upload Required Documents</h2>
                
                @if (session('success'))
                    <div class="bg-green-100 border border-green-500 text-green-700 p-4 mb-4 rounded-md" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <div class="mb-6">
                    <p class="text-gray-600">
                        Please upload all the required documents to complete your registration. All documents must be in PDF, JPG, JPEG, or PNG format.
                    </p>
                </div>

                <form method="POST" action="{{ route('company.documents.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Registre du Commerce -->
                        <div class="space-y-2">
                            <label for="registre_commerce" class="block text-sm font-medium text-gray-700">
                                Registre du Commerce <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="registre_commerce" name="registre_commerce" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('registre_commerce') border-red-500 @enderror">
                            @error('registre_commerce')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Carte Fiscale -->
                        <div class="space-y-2">
                            <label for="carte_fiscale" class="block text-sm font-medium text-gray-700">
                                Carte Fiscale (البطاقة الضريبية) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="carte_fiscale" name="carte_fiscale" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('carte_fiscale') border-red-500 @enderror">
                            @error('carte_fiscale')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- CNAS/CASNOS Certificate -->
                        <div class="space-y-2">
                            <label for="cnas_casnos" class="block text-sm font-medium text-gray-700">
                                CNAS/CASNOS Certificate (شهادة التسجيل في الضمان الاجتماعي) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="cnas_casnos" name="cnas_casnos" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('cnas_casnos') border-red-500 @enderror">
                            @error('cnas_casnos')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Business Operation Permit -->
                        <div class="space-y-2">
                            <label for="autorisation_exploitation" class="block text-sm font-medium text-gray-700">
                                Business Operation Permit (رخصة مزاولة النشاط) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="autorisation_exploitation" name="autorisation_exploitation" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('autorisation_exploitation') border-red-500 @enderror">
                            @error('autorisation_exploitation')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lease or Ownership Deed -->
                        <div class="space-y-2">
                            <label for="contrat_location" class="block text-sm font-medium text-gray-700">
                                Lease or Ownership Deed (عقد الإيجار أو سند الملكية) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="contrat_location" name="contrat_location" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('contrat_location') border-red-500 @enderror">
                            @error('contrat_location')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Commercial Insurance -->
                        <div class="space-y-2">
                            <label for="assurance_entreprise" class="block text-sm font-medium text-gray-700">
                                Commercial Insurance (التأمين التجاري) <span class="text-red-500">*</span>
                            </label>
                            <input type="file" id="assurance_entreprise" name="assurance_entreprise" accept=".pdf,.jpg,.jpeg,.png" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('assurance_entreprise') border-red-500 @enderror">
                            @error('assurance_entreprise')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                            Upload Documents
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection