@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <!-- Header avec gradient -->
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-6 rounded-t-xl shadow-lg text-center">
            <h2 class="text-3xl font-bold text-white">Réinitialisation du mot de passe</h2>
            <p class="text-white mt-2 text-sm">Créez un nouveau mot de passe sécurisé pour votre compte</p>
        </div>

        <!-- Contenu du formulaire -->
        <div class="bg-white rounded-b-xl shadow-lg p-8">
            <div class="flex justify-center mb-6">
                <div class="bg-yellow-100 rounded-full p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            <p class="text-center text-gray-600 mb-6">
                Veuillez choisir un nouveau mot de passe fort pour votre compte. Un bon mot de passe doit contenir des lettres majuscules et minuscules, des chiffres et des caractères spéciaux.
            </p>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Nouveau mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password" type="password" name="password" required
                            class="pl-10 transition-all duration-200 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('password') border-red-500 @enderror">
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
                            <div class="h-1 rounded transition-all duration-300" id="password-strength"></div>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirmer le nouveau mot de passe
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="pl-10 transition-all duration-200 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 toggle-password-confirm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                        Réinitialiser le mot de passe
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    <a href="{{ route('login') }}" class="flex items-center justify-center font-medium text-yellow-600 hover:text-yellow-800 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Retour à la page de connexion
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePasswordButton = document.querySelector('.toggle-password');
    const passwordInput = document.getElementById('password');
    
    togglePasswordButton.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Change the eye icon
        if (type === 'text') {
            this.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                </svg>
            `;
        } else {
            this.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            `;
        }
    });
    
    // Toggle password confirmation visibility
    const togglePasswordConfirmButton = document.querySelector('.toggle-password-confirm');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    
    togglePasswordConfirmButton.addEventListener('click', function() {
        const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmInput.setAttribute('type', type);
        
        // Change the eye icon
        if (type === 'text') {
            this.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                </svg>
            `;
        } else {
            this.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            `;
        }
    });
    
    // Password strength meter
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
    const formInputs = document.querySelectorAll('input');
    
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
        this.classList.add('transform', 'scale-[1.02]');
    });
    
    submitButton.addEventListener('mouseleave', function() {
        this.classList.remove('transform', 'scale-[1.02]');
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const password = passwordInput.value;
        const confirmPassword = passwordConfirmInput.value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            
            // Show error
            passwordConfirmInput.classList.add('border-red-500');
            
            // Add error message if it doesn't exist
            const errorElement = passwordConfirmInput.parentNode.parentNode.querySelector('.error-message');
            if (!errorElement) {
                const message = document.createElement('p');
                message.classList.add('text-red-500', 'text-xs', 'mt-1', 'error-message');
                message.textContent = 'Les mots de passe ne correspondent pas';
                passwordConfirmInput.parentNode.parentNode.appendChild(message);
            }
            
            return;
        }
        
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Réinitialisation en cours...
        `;
    });
});
</script>
@endsection