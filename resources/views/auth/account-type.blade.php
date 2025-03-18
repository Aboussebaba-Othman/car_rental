@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto">
        <div class="bg-yellow-400 p-6 text-center mb-8">
            <h2 class="text-3xl font-bold text-black">Sélectionnez votre type de compte</h2>
        </div>
        
        <div class="bg-gray-50 p-8 rounded-lg shadow-md">
            <div class="mb-6">
                <p class="text-gray-600">Merci de vous être connecté avec Google. Veuillez sélectionner le type de compte que vous souhaitez créer :</p>
            </div>
            
            <form method="POST" action="{{ route('auth.account.type.process') }}">
                @csrf
                
                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div class="flex items-center p-4 border rounded-lg hover:border-yellow-400 cursor-pointer">
                        <input id="account_type_user" type="radio" name="account_type" value="user" class="h-5 w-5 text-yellow-400 focus:ring-yellow-500">
                        <label for="account_type_user" class="ml-3 block text-gray-700 cursor-pointer">
                            <div class="text-lg font-medium">Je suis un particulier</div>
                            <div class="text-sm text-gray-500">Créer un compte pour louer des voitures</div>
                        </label>
                    </div>
                    
                    <div class="flex items-center p-4 border rounded-lg hover:border-yellow-400 cursor-pointer">
                        <input id="account_type_company" type="radio" name="account_type" value="company" class="h-5 w-5 text-yellow-400 focus:ring-yellow-500">
                        <label for="account_type_company" class="ml-3 block text-gray-700 cursor-pointer">
                            <div class="text-lg font-medium">Je suis une entreprise</div>
                            <div class="text-sm text-gray-500">Créer un compte pour louer vos véhicules</div>
                        </label>
                    </div>
                </div>
                
                <div class="mt-8">
                    <button type="submit" class="w-full bg-black text-white px-4 py-3 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                        Continuer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection