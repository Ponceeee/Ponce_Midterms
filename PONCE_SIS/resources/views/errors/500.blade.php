@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-6 py-8 bg-white shadow-lg rounded-lg">
        <div class="text-center">
            <div class="bg-red-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-exclamation-circle text-4xl text-red-400"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Server Error</h2>
            <p class="text-gray-600 mb-6">Something went wrong. Please try again later.</p>
            <div class="space-y-3">
                <a href="{{ url()->previous() }}" 
                   class="block w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Go Back
                </a>
                <a href="{{ route('admin-dashboard') }}" 
                   class="block w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Return to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 