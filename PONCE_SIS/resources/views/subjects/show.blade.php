@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Subject Details</h1>
                <p class="text-purple-100">View subject information</p>
            </div>
            <a href="{{ route('subjects.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Subject Details Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-book text-purple-600 text-xl"></i>
                </div>
                <h2 class="ml-3 text-lg font-semibold text-gray-900">Subject Information</h2>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Subject Code -->
            <div class="flex items-center py-3 border-b border-gray-100">
                <span class="text-sm font-medium text-gray-500 w-1/4">Code:</span>
                <span class="text-sm text-gray-900">{{ $subject->code }}</span>
            </div>

            <!-- Subject Name -->
            <div class="flex items-center py-3 border-b border-gray-100">
                <span class="text-sm font-medium text-gray-500 w-1/4">Name:</span>
                <span class="text-sm text-gray-900">{{ $subject->name }}</span>
            </div>

            <!-- Units -->
            <div class="flex items-center py-3 border-b border-gray-100">
                <span class="text-sm font-medium text-gray-500 w-1/4">Units:</span>
                <span class="text-sm text-gray-900">{{ $subject->units }}</span>
            </div>

            <!-- Status -->
            <div class="flex items-center py-3">
                <span class="text-sm font-medium text-gray-500 w-1/4">Status:</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $subject->status === 'verified' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($subject->status) }}
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('subjects.edit', $subject) }}" 
                   class="px-6 py-2.5 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Subject
                </a>
                @if($subject->status !== 'verified')
                    <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this subject?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="px-6 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
