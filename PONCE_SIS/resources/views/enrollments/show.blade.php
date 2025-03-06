@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Enrollment Details</h1>
                <p class="text-green-100">View enrollment information</p>
            </div>
            <a href="{{ route('enrollments.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Enrollment Details Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-user-graduate text-green-600 text-xl"></i>
                </div>
                <h2 class="ml-3 text-lg font-semibold text-gray-900">Enrollment Information</h2>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Student -->
            <div class="flex items-center py-3 border-b border-gray-100">
                <span class="text-sm font-medium text-gray-500 w-1/4">Student:</span>
                <span class="text-sm text-gray-900">{{ $enrollment->student->name }}</span>
            </div>

            <!-- Subject -->
            <div class="flex items-center py-3 border-b border-gray-100">
                <span class="text-sm font-medium text-gray-500 w-1/4">Subject:</span>
                <span class="text-sm text-gray-900">{{ $enrollment->subject->name }}</span>
            </div>

            <!-- Semester -->
            <div class="flex items-center py-3 border-b border-gray-100">
                <span class="text-sm font-medium text-gray-500 w-1/4">Semester:</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    {{ $enrollment->semester === '1st' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                    {{ $enrollment->semester }}
                </span>
            </div>

            <!-- School Year -->
            <div class="flex items-center py-3">
                <span class="text-sm font-medium text-gray-500 w-1/4">School Year:</span>
                <span class="text-sm text-gray-900">{{ $enrollment->school_year }}</span>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('enrollments.edit', $enrollment) }}" 
                   class="px-6 py-2.5 bg-yellow-600 text-white font-medium rounded-lg hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Enrollment
                </a>
                <form action="{{ route('enrollments.destroy', $enrollment) }}" method="POST" class="inline"
                      onsubmit="return confirm('Are you sure you want to delete this enrollment?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-6 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                        <i class="fas fa-trash mr-2"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
