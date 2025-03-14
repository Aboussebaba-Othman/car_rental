@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h1 class="text-2xl font-semibold text-gray-800">Company Dashboard</h1>
                
                @if (session('info'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 my-4" role="alert">
                        <p>{{ session('info') }}</p>
                    </div>
                @endif
                
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 my-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                <div class="mt-4">
                    <p class="font-bold">Company Name:</p>
                    <p>{{ auth()->user()->company->company_name }}</p>
                </div>
                
                <div class="mt-4">
                    <p class="font-bold">Account Status:</p>
                    <p>
                        @if(auth()->user()->company->is_validated)
                            <span class="text-green-600">Validated</span>
                        @else
                            <span class="text-yellow-600">Pending Validation</span>
                        @endif
                    </p>
                </div>
                
                <div class="mt-4">
                    <p class="font-bold">Document Status:</p>
                    <p>
                        @if(auth()->user()->company->legal_documents)
                            <span class="text-green-600">All documents submitted</span>
                        @else
                            <span class="text-red-600">Documents required</span>
                            <a href="{{ route('company.documents.upload') }}" class="ml-2 text-blue-500 hover:underline">
                                Upload now
                            </a>
                        @endif
                    </p>
                </div>
                
                <!-- Rest of dashboard content -->
            </div>
        </div>
    </div>
</div>
@endsection