@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-8 rounded-t-xl shadow-lg text-center">
            <h2 class="text-3xl font-bold text-white">Créer votre compte personnel</h2>
            <p class="text-white mt-2">Rejoignez notre communauté et commencez à louer des véhicules dès aujourd'hui</p>
        </div>

        <div class="flex flex-col md:flex-row rounded-b-xl shadow-lg overflow-hidden">
            <!-- Left side - Image with overlay text -->
            <div class="w-full md:w-1/3 relative">
                <img src="{{ asset('images/car-rental-sign.webp') }}" alt="User registration" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-end p-6 text-white">
                    <h3 class="text-2xl font-bold mb-4">Avantages de l'inscription</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Réservez des véhicules en quelques clics</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Consultez votre historique de réservations</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Accédez à des offres exclusives</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span>Gérez facilement vos informations personnelles</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right side - Form -->
            <div class="w-full md:w-2/3 bg-white p-8">
                <h3 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Informations personnelles</h3>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">Nom <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="firstName" type="text" name="firstName" value="{{ old('firstName') }}" required
                                    class="transition-all duration-200 pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('firstName') border-red-500 @enderror">
                            </div>
                            @error('firstName')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Prénom <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="lastName" type="text" name="lastName" value="{{ old('lastName') }}" required
                                    class="transition-all duration-200 pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('lastName') border-red-500 @enderror">
                            </div>
                            @error('lastName')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="form-group">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </div>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                    class="transition-all duration-200 pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('email') border-red-500 @enderror">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                </div>
                                <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                                    class="transition-all duration-200 pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('phone') border-red-500 @enderror">
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Optionnel</p>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="form-group">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="password" type="password" name="password" required
                                    class="transition-all duration-200 pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('password') border-red-500 @enderror">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 toggle-password">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div class="mt-1">
                                <div class="text-xs text-gray-500">Force du mot de passe:</div>
                                <div class="mt-1 w-full h-1 bg-gray-200 rounded">
                                    <div class="h-1 rounded transition-all duration-300 bg-gray-400" id="password-strength" style="width: 0%"></div>
                                </div>
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmer le mot de passe <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="transition-all duration-200 pl-10 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 toggle-password-confirm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and consent checkboxes -->
                    <div class="mt-8 space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex items-center h-5">
                                <input id="newsletter" type="checkbox" name="newsletter" class="h-5 w-5 text-yellow-500 rounded border-gray-300 focus:ring-yellow-500 transition duration-200">
                            </div>
                            <label for="newsletter" class="text-sm text-gray-700">
                                Je souhaite recevoir les newsletters et mises à jour sur les offres
                            </label>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="flex items-center h-5">
                                <input id="terms" type="checkbox" name="terms" required class="h-5 w-5 text-yellow-500 rounded border-gray-300 focus:ring-yellow-500 transition duration-200">
                            </div>
                            <div>
                                <label for="terms" class="block text-sm text-gray-700">
                                    J'accepte les <a href="#" class="text-yellow-600 hover:text-yellow-800">Conditions Générales</a> et la <a href="#" class="text-yellow-600 hover:text-yellow-800">Politique de Confidentialité</a> <span class="text-red-500">*</span>
                                </label>
                                <p class="text-xs text-gray-500 mt-1">
                                    Ces informations sont nécessaires pour créer votre compte et seront traitées en toute sécurité.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit button -->
                    <div class="flex justify-end mt-10">
                        <button type="submit" class="transition-all duration-200 bg-yellow-500 text-white px-8 py-3 rounded-lg font-medium hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 shadow-md flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Créer mon compte
                        </button>
                    </div>
                </form>

                <!-- Alternative options -->
                <div class="mt-10 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">
                        Vous avez déjà un compte?
                        <a href="{{ route('login') }}" class="font-medium text-yellow-600 hover:text-yellow-800 transition-colors duration-200">Se connecter</a>
                    </p>
                    <p class="text-sm text-gray-600 mt-2">
                        Vous souhaitez vous inscrire en tant qu'entreprise?
                        <a href="{{ route('register.company') }}" class="font-medium text-yellow-600 hover:text-yellow-800 transition-colors duration-200">Inscription entreprise</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    const togglePasswordButtons = document.querySelectorAll('.toggle-password, .toggle-password-confirm');
    
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
    
    // Form input animations
    const formInputs = document.querySelectorAll('input:not([type="checkbox"])');
    
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
    });
    
    // Button animation
    const submitButton = document.querySelector('button[type="submit"]');
    
    submitButton.addEventListener('mouseenter', function() {
        this.classList.add('transform', 'scale-105');
    });
    
    submitButton.addEventListener('mouseleave', function() {
        this.classList.remove('transform', 'scale-105');
    });
    
    // Form submission
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        // Validate password confirmation
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        
        if (password !== confirmPassword) {
            const confirmPasswordInput = document.getElementById('password_confirmation');
            confirmPasswordInput.classList.add('border-red-500');
            
            // Add error message if it doesn't exist
            let errorMsg = confirmPasswordInput.parentNode.parentNode.querySelector('.error-message');
            if (!errorMsg) {
                errorMsg = document.createElement('p');
                errorMsg.classList.add('text-red-500', 'text-xs', 'mt-1', 'error-message');
                errorMsg.textContent = 'Les mots de passe ne correspondent pas';
                confirmPasswordInput.parentNode.parentNode.appendChild(errorMsg);
            }
            
            return false;
        }
        
        // Show loading state on submit button
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Création en cours...
        `;
        
        return true;
    });
});
</script>
@endsection