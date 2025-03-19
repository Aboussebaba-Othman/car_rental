@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-300 rounded-t-lg p-8 text-center shadow-md">
            <h1 class="text-4xl font-bold text-gray-900">Créer votre compte professionnel</h1>
            <p class="mt-2 text-lg text-gray-800">Rejoignez notre plateforme de location et développez votre business</p>
        </div>

        <div class="flex flex-col md:flex-row bg-white rounded-b-lg shadow-md overflow-hidden">
            <!-- Left side - Image with overlay text -->
            <div class="w-full md:w-1/3 relative">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-6 text-white">
                    <h2 class="text-2xl font-bold mb-2">Pourquoi nous rejoindre?</h2>
                    <ul class="space-y-2">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Accès à des milliers de clients
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Gestion simplifiée de votre flotte
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Visibilité accrue pour votre entreprise
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Support dédié aux professionnels
                        </li>
                    </ul>
                </div>
                <img src="{{ asset('images/car-rental-sign.webp') }}" alt="Business professionals" class="w-full h-full object-cover">
            </div>

            <!-- Right side - Form -->
            <div class="w-full md:w-2/3 p-8">
                <!-- Progress bar -->
                <div class="mb-8">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium">Étape <span id="current-step">1</span> sur 3</span>
                        <span class="text-sm font-medium" id="progress-text">Informations personnelles</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-yellow-400 h-2.5 rounded-full transition-all duration-500" id="progress-bar" style="width: 33%"></div>
                    </div>
                </div>

                <form method="POST" action="{{ route('register.company') }}" enctype="multipart/form-data" id="registration-form" class="space-y-6">
                    @csrf

                    <!-- Step 1: Personal Information -->
                    <div id="step1-form" class="space-y-6">
                        <h2 class="text-2xl font-bold text-gray-900 border-b pb-2">Informations personnelles</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="nom" class="block text-sm font-medium text-gray-700 mb-1">Nom *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <input id="nom" type="text" name="firstName" required class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden mt-1">Ce champ est obligatoire</p>
                            </div>
                            
                            <div>
                                <label for="prenom" class="block text-sm font-medium text-gray-700 mb-1">Prénom *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <input id="prenom" type="text" name="lastName" required class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden mt-1">Ce champ est obligatoire</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                        </svg>
                                    </span>
                                    <input id="email" type="email" name="email" required class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden mt-1">Veuillez saisir une adresse email valide</p>
                            </div>
                            
                            <div>
                                <label for="telephone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                        </svg>
                                    </span>
                                    <input id="telephone" type="text" name="phone" required class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden mt-1">Ce champ est obligatoire</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <input id="password" type="password" name="password" required class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 toggle-password">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden mt-1">Le mot de passe doit contenir au moins 8 caractères</p>
                                <div class="mt-1">
                                    <div class="text-xs text-gray-500">Force du mot de passe:</div>
                                    <div class="mt-1 w-full h-1 bg-gray-200 rounded">
                                        <div class="h-1 rounded transition-all duration-300" id="password-strength"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 toggle-password">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden mt-1">Les mots de passe ne correspondent pas</p>
                            </div>
                        </div>

                        <!-- Next button for step 1 -->
                        <div class="flex justify-end pt-4">
                            <button type="button" id="next-button" class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200 shadow-md flex items-center">
                                Suivant
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Professional Information -->
                    <div id="step2-form" class="hidden space-y-6">
                        <h2 class="text-2xl font-bold text-gray-900 border-b pb-2">Informations professionnelles</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="societe" class="block text-sm font-medium text-gray-700 mb-1">Société *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <input id="societe" type="text" name="company_name" required class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200">
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden mt-1">Ce champ est obligatoire</p>
                            </div>
                            
                            <div>
                                <label for="ville" class="block text-sm font-medium text-gray-700 mb-1">Ville *</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                    <select id="ville" name="city" required class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200 appearance-none">
                                        <option value="" disabled selected>Sélectionnez une ville</option>
                                        <option value="Casablanca">Casablanca</option>
                                        <option value="Rabat">Rabat</option>
                                        <option value="Marrakech">Marrakech</option>
                                        <option value="Tanger">Tanger</option>
                                        <option value="Fès">Fès</option>
                                        <option value="Agadir">Agadir</option>
                                        <option value="Meknès">Meknès</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                        </svg>
                                    </div>
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden mt-1">Veuillez sélectionner une ville</p>
                            </div>
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Adresse *</label>
                            <div class="relative">
                                <span class="absolute top-3 left-3 flex items-center pl-0 pointer-events-none text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                                <textarea id="address" name="address" rows="4" required class="pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition duration-200 resize-none"></textarea>
                            </div>
                            <p class="error-message text-red-500 text-xs italic hidden mt-1">Ce champ est obligatoire</p>
                        </div>

                        <!-- Navigation buttons -->
                        <div class="flex justify-between pt-4">
                            <button type="button" id="prev-button" class="border border-gray-300 bg-white text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200 shadow-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Précédent
                            </button>
                            <button type="button" id="next-button-professional" class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-medium hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200 shadow-md flex items-center">
                                Suivant
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Documents -->
                    <div id="step3-form" class="hidden space-y-6">
                        <h2 class="text-2xl font-bold text-gray-900 border-b pb-2">Documents à fournir</h2>
                        <p class="text-sm text-gray-600 mb-4">Tous les documents doivent être au format PDF, JPG, JPEG ou PNG et ne pas dépasser 5 MB.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Registre du Commerce <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="registre_commerce" type="file" name="registre_commerce" required 
                                        class="hidden @error('registre_commerce') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="registre_commerce" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-lg py-3 px-2 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label group">
                                            <div class="flex flex-col items-center justify-center pt-3 pb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-gray-400 group-hover:text-yellow-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="mb-1 text-xs text-gray-500 text-center"><span class="font-semibold">Cliquez pour importer</span> ou glissez-déposez</p>
                                                <p class="text-xs text-gray-500 file-name text-center">PDF, JPG, JPEG, PNG (Max 5MB)</p>
                                            </div>
                                        </label>
                                        
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden">Ce document est obligatoire</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Carte Fiscale <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="carte_fiscale" type="file" name="carte_fiscale" required 
                                        class="hidden @error('carte_fiscale') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="carte_fiscale" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-lg py-3 px-2 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label group">
                                            <div class="flex flex-col items-center justify-center pt-3 pb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-gray-400 group-hover:text-yellow-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="mb-1 text-xs text-gray-500 text-center"><span class="font-semibold">Cliquez pour importer</span> ou glissez-déposez</p>
                                                <p class="text-xs text-gray-500 file-name text-center">PDF, JPG, JPEG, PNG (Max 5MB)</p>
                                            </div>
                                        </label>
                                        
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden">Ce document est obligatoire</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    CNAS/CASNOS <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="cnas_casnos" type="file" name="cnas_casnos" required 
                                        class="hidden @error('cnas_casnos') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="cnas_casnos" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-lg py-3 px-2 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label group">
                                            <div class="flex flex-col items-center justify-center pt-3 pb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-gray-400 group-hover:text-yellow-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="mb-1 text-xs text-gray-500 text-center"><span class="font-semibold">Cliquez pour importer</span> ou glissez-déposez</p>
                                                <p class="text-xs text-gray-500 file-name text-center">PDF, JPG, JPEG, PNG (Max 5MB)</p>
                                            </div>
                                        </label>
                                        
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden">Ce document est obligatoire</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Autorisation d'Exploitation <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="autorisation_exploitation" type="file" name="autorisation_exploitation" required 
                                        class="hidden @error('autorisation_exploitation') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="autorisation_exploitation" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-lg py-3 px-2 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label group">
                                            <div class="flex flex-col items-center justify-center pt-3 pb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-gray-400 group-hover:text-yellow-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="mb-1 text-xs text-gray-500 text-center"><span class="font-semibold">Cliquez pour importer</span> ou glissez-déposez</p>
                                                <p class="text-xs text-gray-500 file-name text-center">PDF, JPG, JPEG, PNG (Max 5MB)</p>
                                            </div>
                                        </label>
                                        
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden">Ce document est obligatoire</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Contrat de Location/Acte de Propriété <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="contrat_location" type="file" name="contrat_location" required 
                                        class="hidden @error('contrat_location') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="contrat_location" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-lg py-3 px-2 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label group">
                                            <div class="flex flex-col items-center justify-center pt-3 pb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-gray-400 group-hover:text-yellow-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="mb-1 text-xs text-gray-500 text-center"><span class="font-semibold">Cliquez pour importer</span> ou glissez-déposez</p>
                                                <p class="text-xs text-gray-500 file-name text-center">PDF, JPG, JPEG, PNG (Max 5MB)</p>
                                            </div>
                                        </label>
                                        
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden">Ce document est obligatoire</p>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">
                                    Assurance de l'Entreprise <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input id="assurance_entreprise" type="file" name="assurance_entreprise" required 
                                        class="hidden @error('assurance_entreprise') border-red-500 @enderror"
                                        accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="assurance_entreprise" class="flex flex-col items-center justify-center w-full border-2 border-dashed border-gray-300 rounded-lg py-3 px-2 cursor-pointer hover:bg-gray-50 transition-colors duration-200 file-upload-label group">
                                            <div class="flex flex-col items-center justify-center pt-3 pb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="mb-2 h-8 w-8 text-gray-400 group-hover:text-yellow-500 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="mb-1 text-xs text-gray-500 text-center"><span class="font-semibold">Cliquez pour importer</span> ou glissez-déposez</p>
                                                <p class="text-xs text-gray-500 file-name text-center">PDF, JPG, JPEG, PNG (Max 5MB)</p>
                                            </div>
                                        </label>
                                        
                                </div>
                                <p class="error-message text-red-500 text-xs italic hidden">Ce document est obligatoire</p>
                            </div>
                        </div>

                        <!-- Terms and conditions -->
                        <div class="mt-6 space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="offers" type="checkbox" name="offers" class="h-5 w-5 text-yellow-500 rounded border-gray-300 focus:ring-yellow-500 transition duration-200">
                                </div>
                                <label for="offers" class="ml-3 text-sm text-gray-700">
                                    J'accepte de recevoir les offres des partenaires et les actualités.
                                </label>
                            </div>
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="terms" type="checkbox" name="terms" required class="h-5 w-5 text-yellow-500 rounded border-gray-300 focus:ring-yellow-500 transition duration-200">
                                </div>
                                <div class="ml-3">
                                    <label for="terms" class="text-sm text-gray-700">
                                        J'autorise l'utilisation de mes données personnelles conformément à la <a href="#" class="text-yellow-600 underline hover:text-yellow-800">loi 09-08</a>. <span class="text-red-500">*</span>
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1">
                                        Les informations marquées d'un astérisque (*) sont obligatoires et nécessaires au traitement de votre demande.
                                    </p>
                                </div>
                            </div>
                            <p class="error-message text-red-500 text-xs italic hidden mt-1" id="terms-error">Vous devez accepter les conditions avant de continuer</p>
                        </div>

                        <!-- Navigation buttons -->
                        <div class="flex justify-between pt-4">
                            <button type="button" id="prev-button-docs" class="border border-gray-300 bg-white text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200 shadow-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Précédent
                            </button>
                            <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200 shadow-md flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Créer mon compte
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-8 pt-5 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">
                        Vous avez déjà un compte?
                        <a href="{{ route('login') }}" class="font-medium text-yellow-600 hover:text-yellow-800 transition-colors duration-200">Se connecter</a>
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                        Vous souhaitez vous inscrire en tant qu'utilisateur?
                        <a href="{{ route('register') }}" class="font-medium text-yellow-600 hover:text-yellow-800 transition-colors duration-200">Inscription utilisateur</a>
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
    const progressBar = document.getElementById('progress-bar');
    const currentStepText = document.getElementById('current-step');
    const progressText = document.getElementById('progress-text');
    
    const nextButton = document.getElementById('next-button');
    const nextButtonProfessional = document.getElementById('next-button-professional');
    const prevButton = document.getElementById('prev-button');
    const prevButtonDocs = document.getElementById('prev-button-docs');
    
    // Function to show password
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');
    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input');
            if (input.type === 'password') {
                input.type = 'text';
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                        <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                    </svg>
                `;
            } else {
                input.type = 'password';
                this.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                `;
            }
        });
    });

    // Password strength meter
    const passwordInput = document.getElementById('password');
    const passwordStrengthBar = document.getElementById('password-strength');
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        
        // Calculate password strength
        let strength = 0;
        
        // Length
        if (password.length >= 8) {
            strength += 25;
        }
        
        // Contains lowercase letter
        if (/[a-z]/.test(password)) {
            strength += 25;
        }
        
        // Contains uppercase letter
        if (/[A-Z]/.test(password)) {
            strength += 25;
        }
        
        // Contains number
        if (/[0-9]/.test(password)) {
            strength += 25;
        }
        
        // Update the strength bar
        passwordStrengthBar.style.width = strength + '%';
        
        // Set color based on strength
        if (strength <= 25) {
            passwordStrengthBar.className = 'h-1 rounded transition-all duration-300 bg-red-500';
        } else if (strength <= 50) {
            passwordStrengthBar.className = 'h-1 rounded transition-all duration-300 bg-orange-500';
        } else if (strength <= 75) {
            passwordStrengthBar.className = 'h-1 rounded transition-all duration-300 bg-yellow-500';
        } else {
            passwordStrengthBar.className = 'h-1 rounded transition-all duration-300 bg-green-500';
        }
    });

    function showStep1() {
        step1Form.classList.remove('hidden');
        step2Form.classList.add('hidden');
        step3Form.classList.add('hidden');
        
        progressBar.style.width = '33%';
        currentStepText.textContent = '1';
        progressText.textContent = 'Informations personnelles';
    }

    function showStep2() {
        step1Form.classList.add('hidden');
        step2Form.classList.remove('hidden');
        step3Form.classList.add('hidden');
        
        progressBar.style.width = '66%';
        currentStepText.textContent = '2';
        progressText.textContent = 'Informations professionnelles';
    }

    function showStep3() {
        step1Form.classList.add('hidden');
        step2Form.classList.add('hidden');
        step3Form.classList.remove('hidden');
        
        progressBar.style.width = '100%';
        currentStepText.textContent = '3';
        progressText.textContent = 'Documents requis';
    }

    // Validation helper
    function validateField(field, regex = null, customErrorMessage = null) {
        const errorElement = field.parentNode.parentNode.querySelector('.error-message');
        
        if (!field.value) {
            field.classList.add('border-red-500');
            field.classList.remove('border-gray-300');
            
            if (errorElement) {
                errorElement.classList.remove('hidden');
            }
            return false;
        } else if (regex && !regex.test(field.value)) {
            field.classList.add('border-red-500');
            field.classList.remove('border-gray-300');
            
            if (errorElement && customErrorMessage) {
                errorElement.textContent = customErrorMessage;
                errorElement.classList.remove('hidden');
            }
            return false;
        } else {
            field.classList.remove('border-red-500');
            field.classList.add('border-gray-300');
            
            if (errorElement) {
                errorElement.classList.add('hidden');
            }
            return true;
        }
    }

    nextButton.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Validate step 1 fields
        const nom = document.getElementById('nom');
        const prenom = document.getElementById('prenom');
        const email = document.getElementById('email');
        const telephone = document.getElementById('telephone');
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;
        const phoneRegex = /^[0-9+\s]+$/;
        
        const isNomValid = validateField(nom);
        const isPrenomValid = validateField(prenom);
        const isEmailValid = validateField(email, emailRegex, 'Veuillez saisir une adresse email valide');
        const isPhoneValid = validateField(telephone, phoneRegex, 'Veuillez saisir un numéro de téléphone valide');
        const isPasswordValid = validateField(password, passwordRegex, 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule et un chiffre');
        
        // Check if passwords match
        let passwordsMatch = true;
        if (password.value !== passwordConfirmation.value) {
            passwordConfirmation.classList.add('border-red-500');
            passwordConfirmation.classList.remove('border-gray-300');
            const errorElement = passwordConfirmation.parentNode.parentNode.querySelector('.error-message');
            if (errorElement) {
                errorElement.textContent = 'Les mots de passe ne correspondent pas';
                errorElement.classList.remove('hidden');
            }
            passwordsMatch = false;
        } else {
            passwordConfirmation.classList.remove('border-red-500');
            passwordConfirmation.classList.add('border-gray-300');
            const errorElement = passwordConfirmation.parentNode.parentNode.querySelector('.error-message');
            if (errorElement) {
                errorElement.classList.add('hidden');
            }
        }

        if (isNomValid && isPrenomValid && isEmailValid && isPhoneValid && isPasswordValid && passwordsMatch) {
            showStep2();
            
            // Scroll to top of form
            window.scrollTo({
                top: document.querySelector('#registration-form').offsetTop - 20,
                behavior: 'smooth'
            });
        }
    });

    nextButtonProfessional.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Validate step 2 fields
        const societe = document.getElementById('societe');
        const ville = document.getElementById('ville');
        const address = document.getElementById('address');
        
        const isSocieteValid = validateField(societe);
        const isVilleValid = validateField(ville);
        const isAddressValid = validateField(address);

        if (isSocieteValid && isVilleValid && isAddressValid) {
            showStep3();
            
            // Scroll to top of form
            window.scrollTo({
                top: document.querySelector('#registration-form').offsetTop - 20,
                behavior: 'smooth'
            });
        }
    });

    // File upload handling
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const fileName = this.files[0]?.name || 'Cliquez pour importer ou glissez-déposez';
            const fileSize = this.files[0]?.size || 0;
            const maxSize = 5 * 1024 * 1024; // 5MB
            const fileType = this.files[0]?.type || '';
            const allowedTypes = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
            const fileNameElement = this.nextElementSibling.querySelector('.file-name');
            const errorElement = this.parentNode.parentNode.querySelector('.error-message');
            
            if (fileSize > maxSize) {
                errorElement.textContent = 'Le fichier est trop volumineux (max 5MB)';
                errorElement.classList.remove('hidden');
                this.value = ''; // Reset the input
                return;
            }
            
            if (this.files[0] && !allowedTypes.includes(fileType)) {
                errorElement.textContent = 'Type de fichier non autorisé (PDF, JPG, JPEG, PNG uniquement)';
                errorElement.classList.remove('hidden');
                this.value = ''; // Reset the input
                return;
            }
            
            if (fileNameElement) {
                fileNameElement.textContent = fileName.length > 20 ? fileName.substring(0, 20) + '...' : fileName;
                
                // Add a visual indicator that file is selected
                const label = this.nextElementSibling;
                label.classList.add('border-yellow-500', 'border-2');
                label.classList.remove('border-gray-300');
                
                // Hide error message if any
                if (errorElement) {
                    errorElement.classList.add('hidden');
                }
                
                // Add animation for better UX
                label.classList.add('file-selected');
                setTimeout(() => {
                    label.classList.remove('file-selected');
                }, 1000);
            }
        });
        
        // Drag and drop functionality
        const dropArea = input.nextElementSibling;
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            dropArea.classList.add('border-yellow-500', 'bg-yellow-50');
        }
        
        function unhighlight() {
            dropArea.classList.remove('border-yellow-500', 'bg-yellow-50');
        }
        
        dropArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            input.files = files;
            
            // Trigger change event
            const event = new Event('change', { bubbles: true });
            input.dispatchEvent(event);
        }
    });

    prevButton.addEventListener('click', function(e) {
        e.preventDefault();
        showStep1();
        
        // Scroll to top of form
        window.scrollTo({
            top: document.querySelector('#registration-form').offsetTop - 20,
            behavior: 'smooth'
        });
    });

    prevButtonDocs.addEventListener('click', function(e) {
        e.preventDefault();
        showStep2();
        
        // Scroll to top of form
        window.scrollTo({
            top: document.querySelector('#registration-form').offsetTop - 20,
            behavior: 'smooth'
        });
    });
    
    // Form submission
    const registrationForm = document.getElementById('registration-form');
    registrationForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate the terms checkbox
        const termsCheckbox = document.getElementById('terms');
        const termsError = document.getElementById('terms-error');
        
        if (!termsCheckbox.checked) {
            termsError.classList.remove('hidden');
            return;
        } else {
            termsError.classList.add('hidden');
        }
        
        // Validate all required file inputs
        // Validate all required file inputs
        const requiredFileInputs = [
            'registre_commerce',
            'carte_fiscale',
            'cnas_casnos',
            'autorisation_exploitation',
            'contrat_location',
            'assurance_entreprise'
        ];
        
        let allFilesValid = true;
        
        requiredFileInputs.forEach(inputId => {
            const fileInput = document.getElementById(inputId);
            const errorElement = fileInput.parentNode.parentNode.querySelector('.error-message');
            
            if (!fileInput.files || fileInput.files.length === 0) {
                errorElement.classList.remove('hidden');
                allFilesValid = false;
                
                // Highlight the drop area
                const dropArea = fileInput.nextElementSibling;
                dropArea.classList.add('border-red-500');
                dropArea.classList.remove('border-yellow-500', 'border-gray-300');
            }
        });
        
        if (!allFilesValid) {
            // Show error notification
            showNotification('Veuillez télécharger tous les documents requis', 'error');
            return;
        }
        
        // If all validations pass, show loading state and submit the form
        const submitButton = this.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Traitement en cours...
        `;
        
        // Add animation class to form
        this.classList.add('submitting');
        
        // Show success notification
        showNotification('Votre compte est en cours de création...', 'info');
        
        // Submit the form after a short delay (for demonstration purposes)
        setTimeout(() => {
            this.submit();
        }, 1500);
    });
    
    // Notification system
    function showNotification(message, type = 'success') {
        // Remove any existing notifications
        const existingNotifications = document.querySelectorAll('.notification');
        existingNotifications.forEach(notification => {
            notification.remove();
        });
        
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'notification fixed top-4 right-4 p-4 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50';
        
        // Set style based on type
        if (type === 'success') {
            notification.classList.add('bg-green-500', 'text-white');
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>${message}</span>
                </div>
            `;
        } else if (type === 'error') {
            notification.classList.add('bg-red-500', 'text-white');
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>${message}</span>
                </div>
            `;
        } else if (type === 'info') {
            notification.classList.add('bg-blue-500', 'text-white');
            notification.innerHTML = `
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>${message}</span>
                </div>
            `;
        }
        
        // Add dismiss button
        notification.innerHTML += `
            <button class="absolute top-1 right-1 text-white opacity-70 hover:opacity-100" onclick="this.parentNode.remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        `;
        
        // Add to DOM
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 10);
        
        // Auto dismiss after 5 seconds
        setTimeout(() => {
            if (document.body.contains(notification)) {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 5000);
    }
    
    // Input masking for phone number
    const phoneInput = document.getElementById('telephone');
    
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        // Format the phone number
        if (value.length > 0) {
            if (value.length <= 2) {
                value = '+' + value;
            } else if (value.length <= 5) {
                value = '+' + value.substring(0, 2) + ' ' + value.substring(2);
            } else if (value.length <= 8) {
                value = '+' + value.substring(0, 2) + ' ' + value.substring(2, 5) + ' ' + value.substring(5);
            } else if (value.length <= 10) {
                value = '+' + value.substring(0, 2) + ' ' + value.substring(2, 5) + ' ' + value.substring(5, 8) + ' ' + value.substring(8);
            } else {
                value = '+' + value.substring(0, 2) + ' ' + value.substring(2, 5) + ' ' + value.substring(5, 8) + ' ' + value.substring(8, 10) + ' ' + value.substring(10);
            }
        }
        
        e.target.value = value;
    });
    
    // Form field animations
    const formInputs = document.querySelectorAll('input:not([type="file"]):not([type="checkbox"]), textarea, select');
    
    formInputs.forEach(input => {
        // Add focus animation
        input.addEventListener('focus', function() {
            this.parentNode.classList.add('scale-105', 'z-10');
            this.classList.add('ring-2', 'ring-yellow-200', 'ring-opacity-50');
        });
        
        // Remove focus animation
        input.addEventListener('blur', function() {
            this.parentNode.classList.remove('scale-105', 'z-10');
            this.classList.remove('ring-2', 'ring-yellow-200', 'ring-opacity-50');
        });
        
        // Real-time validation
        input.addEventListener('input', function() {
            const inputType = this.type;
            const inputId = this.id;
            const inputValue = this.value;
            
            // Skip validation for empty fields until form submission
            if (!inputValue) return;
            
            // Validate email
            if (inputType === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(inputValue)) {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-300');
                    
                    const errorElement = this.parentNode.parentNode.querySelector('.error-message');
                    if (errorElement) {
                        errorElement.textContent = 'Veuillez saisir une adresse email valide';
                        errorElement.classList.remove('hidden');
                    }
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                    
                    const errorElement = this.parentNode.parentNode.querySelector('.error-message');
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                    }
                }
            }
            
            // Validate password confirmation
            if (inputId === 'password_confirmation') {
                const password = document.getElementById('password').value;
                
                if (inputValue !== password) {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-300');
                    
                    const errorElement = this.parentNode.parentNode.querySelector('.error-message');
                    if (errorElement) {
                        errorElement.textContent = 'Les mots de passe ne correspondent pas';
                        errorElement.classList.remove('hidden');
                    }
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                    
                    const errorElement = this.parentNode.parentNode.querySelector('.error-message');
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                    }
                }
            }
        });
    });
});

// Add custom styling for animations and effects
document.head.insertAdjacentHTML('beforeend', `
    <style>
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 20px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }
        
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
        }
        
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }
        
        /* Form animations */
        #step1-form, #step2-form, #step3-form {
            animation: fadeInUp 0.5s ease-out;
        }
        
        .file-upload-label {
            transition: all 0.3s ease;
        }
        
        .file-upload-label:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .file-selected {
            animation: pulse 0.6s ease-in-out;
        }
        
        /* Form validation styles */
        input:focus:not(.border-red-500), textarea:focus:not(.border-red-500), select:focus:not(.border-red-500) {
            border-color: #FCD34D;
        }
        
        input.border-red-500, textarea.border-red-500, select.border-red-500 {
            animation: shake 0.5s ease-in-out;
        }
        
        /* Button animations */
        button {
            transition: all 0.3s ease;
        }
        
        button:hover:not(:disabled) {
            transform: translateY(-2px);
        }
        
        button:active:not(:disabled) {
            transform: translateY(0);
        }
        
        button:disabled {
            cursor: not-allowed;
            opacity: 0.7;
        }
        
        /* Progress bar animation */
        #progress-bar {
            transition: width 0.5s ease;
        }
        
        /* Form submission animation */
        .submitting {
            position: relative;
        }
        
        .submitting::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, transparent 0%, rgba(255, 255, 255, 0.2) 50%, transparent 100%);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
            pointer-events: none;
        }
        
        /* Notification animation */
        .notification {
            transition: transform 0.3s ease;
        }
    </style>
`);
</script>
@endsection