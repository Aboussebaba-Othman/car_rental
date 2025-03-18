@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-yellow-400 p-6 text-center">
            <h2 class="text-3xl font-bold text-black">Créer votre compte professionnel</h2>
        </div>

        <div class="flex">
            <!-- Left side - Image -->
            <div class="w-1/3">
                <img src="{{ asset('images/car-rental-sign.webp') }}" alt="Business professionals" class="w-full h-full object-cover">
            </div>

            <!-- Right side - Form -->
            <div class="w-2/3 bg-gray-50 p-6">
                <form method="POST" action="{{ route('register.company') }}" enctype="multipart/form-data" id="registration-form">
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
                        <div class="border-t-2 border-gray-300 w-32"></div>
                        <div id="step3-indicator" class="bg-yellow-200 w-20 h-12 flex items-center justify-center font-bold text-black text-xl">
                            3
                        </div>
                    </div>

                    <!-- Step 1: Personal Information -->
                    <div id="step1-form" class="block">
                        <h3 class="text-lg font-bold mb-4">Informations personnelles</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom *:</label>
                                <input id="nom" type="text" name="firstName" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom *:</label>
                                <input id="prenom" type="text" name="lastName" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">E-mail *:</label>
                                <input id="email" type="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone *:</label>
                                <input id="telephone" type="text" name="phone" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe *:</label>
                                <input id="password" type="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                @error('password')
                                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le mot de passe *:</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <!-- Next button for step 1 -->
                        <div class="flex justify-end mt-8">
                            <button type="button" id="next-button" class="bg-black text-white px-8 py-2 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                Suivant
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Professional Information (initially hidden) -->
                    <div id="step2-form" class="hidden">
                        <h3 class="text-lg font-bold mb-4">Informations professionnelles</h3>
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="societe" class="block text-sm font-medium text-gray-700">Société *:</label>
                                <input id="societe" type="text" name="company_name" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="ville" class="block text-sm font-medium text-gray-700">Ville *:</label>
                                <select id="ville" name="city" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="Casablanca">Casablanca</option>
                                    <option value="Rabat">Rabat</option>
                                    <option value="Marrakech">Marrakech</option>
                                    <option value="Tanger">Tanger</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4">
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Adresse *:</label>
                                <textarea id="address" name="address" rows="5" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                            </div>
                        </div>


                        <!-- Navigation buttons -->
                        <div class="flex justify-between mt-8">
                            <button type="button" id="prev-button" class="bg-gray-700 text-white px-8 py-2 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Précédent
                            </button>
                            <button type="button" id="next-button-professional" class="bg-black text-white px-8 py-2 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                                Suivant
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Documents (initially hidden) -->
                    <div id="step3-form" class="hidden">
                        <h3 class="text-lg font-bold mb-4">Documents à fournir</h3>
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
                        <div class="mt-6 space-y-2">
                            <div class="flex items-start">
                                <input id="offers" type="checkbox" name="offers" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="offers" class="ml-2 block text-sm text-gray-700">
                                    J'accepte de recevoir les offres des partenaires.
                                </label>
                            </div>
                            <div class="flex items-start">
                                <input id="terms" type="checkbox" name="terms" required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <div class="ml-2">
                                    <label for="terms" class="block text-xs text-gray-700">
                                        J'autorise l'utilisation de mes données personnelles conformément à la loi 09-08.
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation buttons -->
                        <div class="flex justify-between mt-8">
                            <button type="button" id="prev-button-docs" class="bg-gray-700 text-white px-8 py-2 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Précédent
                            </button>
                            <button type="submit" class="bg-green-600 text-white px-8 py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Créer mon compte
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-bold text-blue-500 hover:text-blue-800">Login</a>
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                        Want to register as a user?
                        <a href="{{ route('register') }}" class="font-bold text-blue-500 hover:text-blue-800">Register as user</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const step1Form = document.getElementById('step1-form');
    const step2Form = document.getElementById('step2-form');
    const step3Form = document.getElementById('step3-form');
    const nextButton = document.getElementById('next-button');
    const nextButtonProfessional = document.getElementById('next-button-professional');
    const prevButton = document.getElementById('prev-button');
    const prevButtonDocs = document.getElementById('prev-button-docs');

    function showStep1() {
        step1Form.classList.remove('hidden');
        step2Form.classList.add('hidden');
        step3Form.classList.add('hidden');
        
        document.getElementById('step1-indicator').classList.add('bg-yellow-400');
        document.getElementById('step2-indicator').classList.remove('bg-yellow-400');
        document.getElementById('step2-indicator').classList.add('bg-yellow-200');
        document.getElementById('step3-indicator').classList.remove('bg-yellow-400');
        document.getElementById('step3-indicator').classList.add('bg-yellow-200');
    }

    function showStep2() {
        step1Form.classList.add('hidden');
        step2Form.classList.remove('hidden');
        step3Form.classList.add('hidden');

        // document.getElementById('step1-indicator').classList.remove('bg-yellow-400');
        // document.getElementById('step1-indicator').classList.add('bg-yellow-200');
        document.getElementById('step2-indicator').classList.add('bg-yellow-400');
        document.getElementById('step3-indicator').classList.remove('bg-yellow-400');
        document.getElementById('step3-indicator').classList.add('bg-yellow-200');
    }

    function showStep3() {
        step1Form.classList.add('hidden');
        step2Form.classList.add('hidden');
        step3Form.classList.remove('hidden');

        // document.getElementById('step1-indicator').classList.remove('bg-yellow-400');
        // document.getElementById('step1-indicator').classList.add('bg-yellow-200');
        // document.getElementById('step2-indicator').classList.remove('bg-yellow-400');
        // document.getElementById('step2-indicator').classList.add('bg-yellow-200');
        document.getElementById('step3-indicator').classList.add('bg-yellow-400');
    }

    nextButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Validate step 1 fields
        const requiredFields = ['nom', 'prenom', 'email', 'telephone', 'password', 'password_confirmation'];    
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
        
        // Check if passwords match
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        if (password.value !== passwordConfirmation.value) {
            isValid = false;
            password.classList.add('border-red-500');
            passwordConfirmation.classList.add('border-red-500');
        }

        if (isValid) {
            showStep2();
        }
    });

    nextButtonProfessional.addEventListener('click', function(e) {
        e.preventDefault();
        // Validate step 2 fields
        const requiredFields = ['societe', 'ville', 'address'];    
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
            showStep3();
        }
    });
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

    prevButton.addEventListener('click', function(e) {
        e.preventDefault();
        showStep1();
    });

    prevButtonDocs.addEventListener('click', function(e) {
        e.preventDefault();
        showStep2();
    });
});
</script>
@endsection