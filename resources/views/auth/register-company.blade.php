@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-yellow-400 p-6 text-center mb-8">
            <h2 class="text-3xl font-bold text-black">Créer votre compte professionnel</h2>
        </div>

        <div class="flex">
            <!-- Left side - Image -->
            <div class="w-1/3">
                <img src="./close-up-hand-holding-car-keys.jpg" alt="Business professionals" class="w-full h-full object-cover">
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
                    </div>

                    <!-- Section titles -->
                    <div class="flex justify-between mb-6">
                        <div class="w-1/2 text-center">
                            <h3 class="text-lg font-bold">Informations personnelles</h3>
                        </div>
                        <div class="w-1/2 text-center">
                            <h3 class="text-lg font-bold">Informations professionnelles</h3>
                        </div>
                    </div>

                    <!-- Step 1: Personal Information (visible first) -->
                    <div id="step1-form" class="block">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700">Nom *:</label>
                                <input id="nom" type="text" name="nom" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700">Prénom *:</label>
                                <input id="prenom" type="text" name="prenom" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">E-mail *:</label>
                                <input id="email" type="email" name="email" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone *:</label>
                                <input id="telephone" type="text" name="telephone" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
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
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label for="societe" class="block text-sm font-medium text-gray-700">Société *:</label>
                                <input id="societe" type="text" name="societe" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                <p class="text-xs text-gray-500 mt-1">Merci de mettre la société</p>
                            </div>
                            <div>
                                <label for="ville" class="block text-sm font-medium text-gray-700">Ville *:</label>
                                <select id="ville" name="ville" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="Casablanca">Casablanca</option>
                                    <option value="Rabat">Rabat</option>
                                    <option value="Marrakech">Marrakech</option>
                                    <option value="Tanger">Tanger</option>
                                </select>
                            </div>
                            
                            
                            
                        </div>

                        <div class="grid grid-cols-1 gap-6 mt-4">
                            
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700">Adress *:</label>
                                <textarea id="address" rows="5" cols="50" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>                            </div>
                        </div>
                        

                        <!-- Consent checkboxes -->
                        <div class="mt-6 space-y-2">
                            <div class="flex items-start">
                                <input id="offers" type="checkbox" name="offers" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <label for="offers" class="ml-2 block text-sm text-gray-700">
                                    J'accepte de recevoir les offres des partenaires Télécontact
                                </label>
                            </div>
                            <div class="flex items-start">
                                <input id="terms" type="checkbox" name="terms" required class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                <div class="ml-2">
                                    <label for="terms" class="block text-xs text-gray-700">
                                        J'autorise Edicom à utiliser mes données personnelles pour des fins d'affichage sur ses supports papiers et internet et que mes données soit publiées sur un annuaire susceptible d'être vendu à des tiers. Conformément à la loi 09-08, je suis informé de mes droits d'accès, de rectification et d'opposition pour des motifs légitime en contactant <a href="mailto:donnees.personnelles@edicom.ma" class="text-blue-600 hover:underline">donnees.personnelles@edicom.ma</a>. Ce traitement a fait l'objet d'une déclaration à la CNDP sous le N° D-M-310/2015
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation buttons -->
                        <div class="flex justify-between mt-8">
                            <button type="button" id="prev-button" class="bg-gray-700 text-white px-8 py-2 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Précédent
                            </button>
                            <button type="submit" class="bg-green-600 text-white px-8 py-2 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
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
        
        // step1Indicator.classList.remove('bg-yellow-400');
        // step1Indicator.classList.add('bg-yellow-200');
        step2Indicator.classList.remove('bg-yellow-200');
        step2Indicator.classList.add('bg-yellow-400');
    }

    // Event listener for Next button
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

    // Event listener for Previous button
    prevButton.addEventListener('click', function(e) {
        e.preventDefault();
        showStep1();
    });
});
</script>
@endsection