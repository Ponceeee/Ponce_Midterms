@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Add Subject</h1>
                <p class="text-purple-100">Create a new subject in the system</p>
            </div>
            <a href="{{ route('subjects.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-book text-purple-600 text-xl"></i>
                </div>
                <h2 class="ml-3 text-lg font-semibold text-gray-900">Subject Details</h2>
            </div>
        </div>

        <form action="{{ route('subjects.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Subject Code -->
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Subject Code <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="code" 
                               id="code"
                               value="{{ old('code') }}"
                               class="w-full px-4 py-2.5 rounded-lg border @error('code') border-red-300 @else border-gray-300 @enderror
                                      focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                      transition-colors"
                               placeholder="Enter subject code"
                               required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            @error('code')
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            @enderror
                        </div>
                    </div>
                    @error('code')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject Name -->
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Subject Name <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" 
                               name="name" 
                               id="name"
                               value="{{ old('name') }}"
                               class="w-full px-4 py-2.5 rounded-lg border @error('name') border-red-300 @else border-gray-300 @enderror
                                      focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                      transition-colors"
                               placeholder="Enter subject name"
                               required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            @error('name')
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            @enderror
                        </div>
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Units -->
                <div>
                    <label for="units" class="block text-sm font-medium text-gray-700 mb-1">Units</label>
                    <input type="number" name="units" id="units" 
                        value="{{ old('units') }}"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    @error('units')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('subjects.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Add Subject
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('subjectForm');
    const codeInput = document.getElementById('code');
    const nameInput = document.getElementById('name');
    let checkTimeout;

    function checkSubjectExists(input) {
        clearTimeout(checkTimeout);
        const value = input.value;
        const field = input.name;
        
        if (!value) return;

        // Add loading indicator
        const iconContainer = input.parentElement.querySelector('.absolute.inset-y-0.right-0');
        iconContainer.innerHTML = '<i class="fas fa-spinner fa-spin text-gray-400"></i>';
        
        checkTimeout = setTimeout(() => {
            fetch(`/check-subject?${field}=${encodeURIComponent(value)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        // Subject exists
                        input.setCustomValidity(`This subject ${field} already exists`);
                        iconContainer.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i>';
                        input.classList.add('border-red-300');
                        input.classList.remove('border-green-300');
                        
                        // Show error message
                        let errorMsg = input.parentElement.parentElement.querySelector('.text-red-600');
                        if (!errorMsg) {
                            errorMsg = document.createElement('p');
                            errorMsg.className = 'mt-1 text-sm text-red-600';
                            input.parentElement.parentElement.appendChild(errorMsg);
                        }
                        errorMsg.textContent = `This subject ${field} is already in use`;
                    } else {
                        // Subject is available
                        input.setCustomValidity('');
                        iconContainer.innerHTML = '<i class="fas fa-check-circle text-green-500"></i>';
                        input.classList.remove('border-red-300');
                        input.classList.add('border-green-300');
                        
                        // Remove error message if exists
                        const errorMsg = input.parentElement.parentElement.querySelector('.text-red-600');
                        if (errorMsg) errorMsg.remove();
                    }
                })
                .catch(error => {
                    console.error('Error checking subject:', error);
                });
        }, 500);
    }

    // Add event listeners for both code and name inputs
    codeInput.addEventListener('input', () => checkSubjectExists(codeInput));
    nameInput.addEventListener('input', () => checkSubjectExists(nameInput));

    // Form submission handling
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) {
                firstInvalid.focus();
                // Show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please check the form for errors.',
                    confirmButtonColor: '#3085d6'
                });
            }
        }
    });
});
</script>
@endsection
