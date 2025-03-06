@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full px-6 py-8 bg-white shadow-lg rounded-lg">
        <div class="text-center">
            <div class="bg-gray-100 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-exclamation-triangle text-4xl text-gray-400"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Page Not Found</h2>
            <p class="text-gray-600 mb-6">The page you're looking for doesn't exist or has been moved.</p>
            <div class="space-y-3">
                <a href="{{ url()->previous() }}" 
                   class="block w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Go Back
                </a>
                <a href="{{ route('admin-dashboard') }}" 
                   class="block w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Return to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 