@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-orange-600 to-red-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Edit Grade</h1>
                <p class="text-orange-100">Update grade information</p>
            </div>
            <a href="{{ route('grades.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center">
                <div class="bg-orange-100 rounded-full p-3">
                    <i class="fas fa-edit text-orange-600 text-xl"></i>
                </div>
                <h2 class="ml-3 text-lg font-semibold text-gray-900">Grade Details</h2>
            </div>
        </div>

        <form action="{{ route('grades.update', $grade) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                    <div class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-300 text-gray-500">
                        {{ $grade->student->name }}
                    </div>
                </div>

                <!-- Subject (Read-only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <div class="w-full px-4 py-2.5 rounded-lg bg-gray-50 border border-gray-300 text-gray-500">
                        {{ $grade->subject->name }}
                    </div>
                </div>

                <!-- Midterm Grade -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Midterm Grade</label>
                    <input type="number" name="midterm" 
                        value="{{ old('midterm', $grade->midterm) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        step="0.01" min="1.00" max="5.00" required>
                    @error('midterm')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Final Grade -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Final Grade</label>
                    <input type="number" name="final" 
                        value="{{ old('final', $grade->final) }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        step="0.01" min="1.00" max="5.00" required>
                    @error('final')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" 
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        rows="3" required>{{ old('description', $grade->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('grades.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
