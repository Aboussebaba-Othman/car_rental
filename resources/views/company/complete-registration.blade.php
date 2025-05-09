@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-yellow-400 p-6 text-center mb-8">
            <h2 class="text-3xl font-bold text-black">Complétez votre inscription entreprise</h2>
        </div>

        <div class="flex">
            <!-- Left side - Image -->
            <div class="w-1/3 hidden lg:block">
                <div class="relative h-full">
                    <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" 
                         alt="Business professionals" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <h3 class="text-xl font-bold">Rejoignez notre réseau d'entreprises</h3>
                        <p class="mt-2 text-sm opacity-90">Complétez votre profil pour accéder à tous nos services</p>
                    </div>
                </div>
            </div>

            <!-- Right side - Form -->
            <div class="w-full lg:w-2/3 bg-gray-50 p-6">
                <form method="POST" action="{{ route('company.complete-registration.process') }}" enctype="multipart/form-data" id="registration-form">
                    @csrf

                    <!-- Step indicators -->
                    <div class="flex justify-center items-center mb-6">
                        <div id="step1-indicator" class="bg-yellow-400 w-20 h-12 flex items-center justify-center font-bold text-black text-xl">
                            1
                        </div>
                        <div class="border-t-2 border-gray-300 w-32"></div>
                        <div id="step2-indicator" class="bg-yellow-200 w-20 h-12 flex items-center justify-center font-bold text-black text-xl">
                            2
                        </div>
                    </div>

                    <!-- Section titles -->
                    <div class="flex justify-between mb-6">
                        <div class="w-1/2 text-center">
                            <h3 class="text-lg font-bold">Informations entreprise</h3>
                        </div>
                        <div class="w-1/2 text-center">
                            <h3 class="text-lg font-bold">Documents obligatoires</h3>
                        </div>
                    </div>

                    <!-- Step 1: Company Information (visible first) -->
                    <div id="step1-form" class="block">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="company_name" class="block text-sm font-medium text-gray-700">
                                    Société <span class="text-red-500">*</span>
                                </label>
                                <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" required 
                                    class="block w-full border border-gray-300 rounded-md shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200 @error('company_name') border-red-500 @enderror">
                                @error('company_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-1">Merci de mettre la société</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Téléphone <span class="text-red-500">*</span>
                                </label>
                                <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required 
                                    class="block w-full border border-gray-300 rounded-md shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">
                                    Adresse <span class="text-red-500">*</span>
                                </label>
                                <input id="address" type="text" name="address" value="{{ old('address') }}" required 
                                    class="block w-full border border-gray-300 rounded-md shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200 @error('address') border-red-500 @enderror">
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="city" class="block text-sm font-medium text-gray-700">
                                    Ville <span class="text-red-500">*</span>
                                </label>
                                <select id="city" name="city" required 
                                    class="block w-full border border-gray-300 rounded-md shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 transition-all duration-200 @error('city') border-red-500 @enderror">
                                    <option value="">Sélectionner une ville</option>
                                    <option value="Alger">Alger</option>
                                    <option value="Oran">Oran</option>
                                    <option value="Constantine">Constantine</option>
                                    <option value="Annaba">Annaba</option>
                                </select>
                                @error('city')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Next button for step 1 -->
                        <div class="flex justify-end mt-8">
                            <button type="button" id="next-button" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-all duration-200">
                                Suivant
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Required Documents (initially hidden) -->
                    <div id="step2-form" class="hidden">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="registre_commerce" class="block text-sm font-medium text-gray-700">
                                    Registre du Commerce <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="registre_commerce" type="file" name="registre_commerce" required 
                                        class="hidden @error('registre_commerce') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="registre_commerce" class="flex items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-md py-3 px-4 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="text-sm text-gray-500 file-name">Choisir un fichier</span>
                                    </label>
                                </div>
                                @error('registre_commerce')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="carte_fiscale" class="block text-sm font-medium text-gray-700">
                                    Carte Fiscale <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="carte_fiscale" type="file" name="carte_fiscale" required 
                                        class="hidden @error('carte_fiscale') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="carte_fiscale" class="flex items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-md py-3 px-4 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="text-sm text-gray-500 file-name">Choisir un fichier</span>
                                    </label>
                                </div>
                                @error('carte_fiscale')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="cnas_casnos" class="block text-sm font-medium text-gray-700">
                                    CNAS/CASNOS <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="cnas_casnos" type="file" name="cnas_casnos" required 
                                        class="hidden @error('cnas_casnos') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="cnas_casnos" class="flex items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-md py-3 px-4 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="text-sm text-gray-500 file-name">Choisir un fichier</span>
                                    </label>
                                </div>
                                @error('cnas_casnos')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="autorisation_exploitation" class="block text-sm font-medium text-gray-700">
                                    Autorisation d'Exploitation <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="autorisation_exploitation" type="file" name="autorisation_exploitation" required 
                                        class="hidden @error('autorisation_exploitation') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="autorisation_exploitation" class="flex items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-md py-3 px-4 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="text-sm text-gray-500 file-name">Choisir un fichier</span>
                                    </label>
                                </div>
                                @error('autorisation_exploitation')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="contrat_location" class="block text-sm font-medium text-gray-700">
                                    Contrat de Location/Acte de Propriété <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="contrat_location" type="file" name="contrat_location" required 
                                        class="hidden @error('contrat_location') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="contrat_location" class="flex items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-md py-3 px-4 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="text-sm text-gray-500 file-name">Choisir un fichier</span>
                                    </label>
                                </div>
                                @error('contrat_location')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="assurance_entreprise" class="block text-sm font-medium text-gray-700">
                                    Assurance de l'Entreprise <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="assurance_entreprise" type="file" name="assurance_entreprise" required 
                                        class="hidden @error('assurance_entreprise') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                    <label for="assurance_entreprise" class="flex items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-md py-3 px-4 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                        </svg>
                                        <span class="text-sm text-gray-500 file-name">Choisir un fichier</span>
                                    </label>
                                </div>
                                @error('assurance_entreprise')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Terms and conditions -->
                        <div class="mt-8 space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" name="terms" type="checkbox" required
                                        class="h-4 w-4 text-yellow-500 focus:ring-yellow-400 border-gray-300 rounded transition-colors duration-200">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="terms" class="text-gray-600">
                                        J'accepte de recevoir les offres des partenaires Télécontact
                                    </label>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="privacy" name="privacy" type="checkbox" required
                                        class="h-4 w-4 text-yellow-500 focus:ring-yellow-400 border-gray-300 rounded transition-colors duration-200">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="privacy" class="text-gray-600">
                                        J'autorise Edicom à utiliser mes données personnelles pour des fins d'affichage sur ses supports papiers et internet et que mes données soit publiées sur un annuaire susceptible d'être vendu à des tiers. Conformément à la loi 09-08, je suis informé de mes droits d'accès, de rectification et d'opposition pour des motifs légitime en contactant <a href="mailto:donnees.personnelles@edicom.ma" class="text-yellow-600 hover:underline">donnees.personnelles@edicom.ma</a>. Ce traitement a fait l'objet d'une déclaration à la CNDP sous le N° D-M-310/2015
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation buttons -->
                        <div class="mt-10 flex justify-between">
                            <button type="button" id="prev-button" class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-400 transition-all duration-200">
                                Précédent
                            </button>
                            <button type="submit" id="submit-btn" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition-all duration-200 transform hover:scale-105">
                                Créer mon compte
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const step1Form = document.getElementById('step1-form');
    const step2Form = document.getElementById('step2-form');
    const step1Indicator = document.getElementById('step1-indicator');
    const step2Indicator = document.getElementById('step2-indicator');
    const nextButton = document.getElementById('next-button');
    const prevButton = document.getElementById('prev-button');
    const submitBtn = document.getElementById('submit-btn');

    // Function to show step 1 and hide step 2
    function showStep1() {
        step1Form.classList.remove('hidden');
        step1Form.classList.add('block');
        step2Form.classList.add('hidden');
        step2Form.classList.remove('block');
        
        step1Indicator.classList.remove('bg-yellow-200');
        step1Indicator.classList.add('bg-yellow-400');
        step2Indicator.classList.remove('bg-yellow-400');
        step2Indicator.classList.add('bg-yellow-200');
    }

    // Function to show step 2 and hide step 1
    function showStep2() {
        step1Form.classList.add('hidden');
        step1Form.classList.remove('block');
        step2Form.classList.remove('hidden');
        step2Form.classList.add('block');
        
        // step1Indicator.classList.add('bg-gray-200');
        // step1Indicator.classList.remove('bg-yellow-400');
        step2Indicator.classList.remove('bg-yellow-200');
        step2Indicator.classList.add('bg-yellow-400');
    }

    // Event listener for Next button
    nextButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Validate step 1 fields
        const requiredFields = ['company_name', 'phone', 'address', 'city'];
        let isValid = true;
        
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value) {
                isValid = false;
                field.classList.add('border-red-500');
            } else {
                field.classList.remove('border-red-500');
            }
        });
        
        if (isValid) {
            showStep2();
        }
    });

    // Event listener for Previous button
    prevButton.addEventListener('click', function(e) {
        e.preventDefault();
        showStep1();
    });
    
    // File upload handling
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Choisir un fichier';
            const fileLabel = this.nextElementSibling.querySelector('.file-name');
            
            if (fileLabel) {
                fileLabel.textContent = fileName;
                
                // Add a visual indicator that file is selected
                const label = this.nextElementSibling;
                label.classList.add('border-yellow-400', 'bg-yellow-50');
                label.classList.remove('border-gray-300');
                
                // Add animation
                label.classList.add('file-selected');
                setTimeout(() => {
                    label.classList.remove('file-selected');
                }, 1000);
            }
        });
    });
   
});
</script>

<style>
/* File upload animation */
.file-upload-label {
    transition: all 0.3s ease;
}

.file-selected {
    animation: pulse 1s;
}

@keyframes pulse {
    0%, 100% { 
        transform: scale(1); 
    }
    50% { 
        transform: scale(1.03); 
    }
}

/* Form field focus animation */
input:focus, select:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Checkbox animation */
input[type="checkbox"] {
    transition: all 0.2s ease;
}

input[type="checkbox"]:checked {
    transform: scale(1.1);
}
</style>
@endsection