@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 p-6 rounded-t-xl shadow-lg text-center">
            <h2 class="text-3xl font-bold text-white">Réinitialisation du mot de passe</h2>
            <p class="text-white mt-2">Nous vous enverrons un lien pour créer un nouveau mot de passe</p>
        </div>

        <div class="flex flex-col md:flex-row rounded-b-xl shadow-lg overflow-hidden">
            <!-- Left side - Image with overlay text -->
            <div class="w-full md:w-1/2 relative">
                <img src="{{ asset('images/car-rental-sign.webp') }}" alt="Sécurité" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col justify-center p-6 text-white">
                    <div class="mx-auto mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 text-center">Mot de passe oublié?</h3>
                    <p class="text-center mb-4">Pas de panique! Nous vous aiderons à récupérer l'accès à votre compte en quelques étapes simples.</p>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Entrez votre adresse email
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Recevez un email avec un lien
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Créez un nouveau mot de passe
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Connectez-vous à votre compte
                        </li>
                    </ul>
                    
                    <!-- Ajout d'une section sur la sécurité -->
                    <div class="mt-6 pt-6 border-t border-white border-opacity-20">
                        <h4 class="font-bold mb-2">Conseils de sécurité:</h4>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <span>Créez un mot de passe fort avec au moins 8 caractères, incluant des majuscules, minuscules, chiffres et symboles.</span>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-400 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                <span>Utilisez un mot de passe unique que vous n'utilisez pas sur d'autres sites.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right side - Reset Password Form -->
            <div class="w-full md:w-1/2 bg-white p-8">
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md flex items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md flex items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <h3 class="text-xl font-bold mb-6 text-gray-800 border-b pb-2">Récupération de compte</h3>
                
                <p class="text-gray-600 mb-6">
                    Entrez l'adresse e-mail associée à votre compte et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                </p>

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Adresse email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                                class="pl-10 transition-all duration-200 block w-full border border-gray-300 rounded-lg shadow-sm py-3 px-4 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-transparent @error('email') border-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-yellow-500 hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                            Envoyer le lien de réinitialisation
                        </button>
                    </div>
                </form>

                <!-- Ajout d'une section FAQ pour équilibrer la hauteur -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h4 class="font-bold text-lg text-gray-800 mb-4">Questions fréquentes</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <h5 class="font-medium text-gray-700">Je n'ai pas reçu l'email de réinitialisation</h5>
                            <p class="text-sm text-gray-600 mt-1">
                                Vérifiez votre dossier de spam ou courrier indésirable. L'email devrait arriver dans les 5 minutes. Si vous ne le recevez toujours pas, vous pouvez réessayer.
                            </p>
                        </div>
                        
                        <div>
                            <h5 class="font-medium text-gray-700">Le lien de réinitialisation a expiré</h5>
                            <p class="text-sm text-gray-600 mt-1">
                                Les liens de réinitialisation expirent après 60 minutes pour des raisons de sécurité. Vous pouvez demander un nouveau lien en utilisant ce formulaire.
                            </p>
                        </div>
                        
                        <div>
                            <h5 class="font-medium text-gray-700">Je ne me souviens pas de mon email</h5>
                            <p class="text-sm text-gray-600 mt-1">
                                Veuillez contacter notre service client à <a href="mailto:support@autoloc.com" class="text-yellow-600 hover:text-yellow-800">support@autoloc.com</a> pour obtenir de l'aide.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('login') }}" class="flex items-center justify-center font-medium text-yellow-600 hover:text-yellow-800 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Retour à la page de connexion
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Form submission animation
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        submitButton.disabled = true;
        submitButton.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Envoi en cours...
        `;
    });
});
</script>
@endsection