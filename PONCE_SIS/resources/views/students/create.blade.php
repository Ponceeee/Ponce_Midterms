@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Student Management</h1>
                <p class="text-blue-100">Add new students or manage pending registrations</p>
            </div>
            <div class="hidden sm:block">
                <a href="{{ route('students.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Students
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3 text-lg"></i>
                <span class="text-green-700">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3 text-lg"></i>
                <span class="text-red-700">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    <!-- Main Content -->
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Tabs -->
        <div class="bg-gray-50 border-b border-gray-200 px-6 py-4">
            <div class="flex space-x-8">
                <button onclick="switchTab('add-student')" 
                        class="tab-button pb-3 px-1 border-b-2 font-medium text-sm focus:outline-none active-tab" 
                        id="add-student-tab">
                    <i class="fas fa-user-plus mr-2"></i>Add New Student
                </button>
                <button onclick="switchTab('pending-students')" 
                        class="tab-button pb-3 px-1 border-b-2 font-medium text-sm focus:outline-none" 
                        id="pending-students-tab">
                    <i class="fas fa-clock mr-2"></i>Pending Registrations
                    @if($pendingStudents->count() > 0)
                        <span class="ml-2 bg-red-100 text-red-600 px-2 py-0.5 rounded-full text-xs">
                            {{ $pendingStudents->count() }}
                        </span>
                    @endif
                </button>
            </div>
        </div>

        <div class="p-6">
            <!-- Add Student Tab -->
            <div id="add-student" class="tab-content">
                <form method="POST" action="{{ route('students.store') }}" class="space-y-8" id="studentForm">
            @csrf
                    <!-- Personal Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-user-circle mr-2 text-blue-500"></i>
                            Personal Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Full Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border @error('name') border-red-300 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Enter student's full name"
                                           required>
                                    @error('name')
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border @error('email') border-red-300 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Enter student's email"
                                           required>
                                    @error('email')
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="tel" 
                                           name="phone" 
                                           value="{{ old('phone') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border @error('phone') border-red-300 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Enter phone number"
                                           required
                                           pattern="[0-9]{11}">
                                    @error('phone')
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @else
                                    <p class="mt-1 text-xs text-gray-500">Format: 11 digits number</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Age <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="age" 
                                           value="{{ old('age') }}"
                                           class="w-full px-4 py-2.5 rounded-lg border @error('age') border-red-300 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Enter age"
                                           required
                                           min="16"
                                           max="100">
                                    @error('age')
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('age')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Gender <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="gender" 
                                            class="w-full px-4 py-2.5 rounded-lg border @error('gender') border-red-300 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            required>
                                        <option value="" disabled {{ !old('gender') ? 'selected' : '' }}>Select Gender</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                                    @error('gender')
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('gender')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                            </div>
                        </div>
                </div>

                    <!-- Academic Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-graduation-cap mr-2 text-blue-500"></i>
                            Academic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Year Level <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="year_level" 
                                            class="w-full px-4 py-2.5 rounded-lg border @error('year_level') border-red-300 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            required>
                                        <option value="" disabled {{ !old('year_level') ? 'selected' : '' }}>Select Year Level</option>
                                        @for ($i = 1; $i <= 6; $i++)
                                            <option value="{{ $i }}" {{ old('year_level') == $i ? 'selected' : '' }}>{{ $i }} Year</option>
                        @endfor
                    </select>
                    @error('year_level')
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('year_level')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Course <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="course" 
                                            class="w-full px-4 py-2.5 rounded-lg border @error('course') border-red-300 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            required>
                                        <option value="" disabled {{ !old('course') ? 'selected' : '' }}>Select Course</option>
                                        <option value="IT" {{ old('course') == 'IT' ? 'selected' : '' }}>Information Technology</option>
                                        <option value="NURSING" {{ old('course') == 'NURSING' ? 'selected' : '' }}>Nursing</option>
                                        <option value="EDUC" {{ old('course') == 'EDUC' ? 'selected' : '' }}>Education</option>
                                        <option value="BUSINESS AD" {{ old('course') == 'BUSINESS AD' ? 'selected' : '' }}>Business Administration</option>
                                        <option value="ACCOUNTING" {{ old('course') == 'ACCOUNTING' ? 'selected' : '' }}>Accounting</option>
                    </select>
                    @error('course')
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-exclamation-circle text-red-500"></i>
                                        </div>
                                    @enderror
                                </div>
                                @error('course')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Address <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea name="address" 
                                      class="w-full px-4 py-2.5 rounded-lg border @error('address') border-red-300 @else border-gray-300 @enderror focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      rows="3" 
                                      placeholder="Enter complete address"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="absolute top-3 right-3">
                                    <i class="fas fa-exclamation-circle text-red-500"></i>
                                </div>
                            @enderror
                        </div>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
            </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6">
                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Save Student
                </button>
            </div>
        </form>
    </div>

            <!-- Pending Students Tab -->
            <div id="pending-students" class="tab-content hidden">
                @if($pendingStudents->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Year Level</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pendingStudents as $student)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->course }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $student->year_level }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex space-x-3">
                                                <form action="{{ route('students.approve', $student->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-green-600 hover:text-green-900 transition-colors">
                                                        <i class="fas fa-check-circle"></i> Approve
                                                    </button>
                                                </form>
                                                <form action="{{ route('students.decline', $student->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                                        <i class="fas fa-times-circle"></i> Reject
                                                    </button>
                                                </form>
                                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="bg-gray-50 rounded-lg p-6 inline-block">
                            <i class="fas fa-inbox text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500">No pending student registrations</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .tab-button {
        @apply text-gray-500 border-transparent hover:text-gray-700 hover:border-gray-300 transition-all duration-200;
    }
    .tab-button.active-tab {
        @apply border-blue-500 text-blue-600;
    }
    input:focus, select:focus, textarea:focus {
        @apply ring-2 ring-blue-500 border-transparent outline-none;
    }
    .form-input-icon {
        @apply absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400;
    }
</style>

<script>
    function switchTab(tabId) {
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });
        
        document.querySelectorAll('.tab-button').forEach(tab => {
            tab.classList.remove('active-tab');
        });
        
        document.getElementById(tabId).classList.remove('hidden');
        document.getElementById(tabId + '-tab').classList.add('active-tab');
    }

    // Add confirmation for reject action
    document.querySelectorAll('form[action*="decline"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to reject this student?')) {
                e.preventDefault();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('studentForm');
        const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');

        // Real-time validation
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                validateInput(this);
            });

            input.addEventListener('blur', function() {
                validateInput(this);
            });
        });

        function validateInput(input) {
            const isValid = input.checkValidity();
            if (isValid) {
                input.classList.remove('border-red-300');
                input.classList.add('border-green-300');
            } else {
                input.classList.remove('border-green-300');
                input.classList.add('border-red-300');
            }
        }

        // Phone number validation
        const phoneInput = document.querySelector('input[name="phone"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);
                e.target.value = value;
            });
        }

        // Email duplicate checking
        const emailInput = document.querySelector('input[name="email"]');
        let emailCheckTimeout;

        emailInput.addEventListener('input', function() {
            clearTimeout(emailCheckTimeout);
            const email = this.value;
            
            // Add loading indicator
            const loadingIcon = '<i class="fas fa-spinner fa-spin text-gray-400"></i>';
            const iconContainer = this.parentElement.querySelector('.absolute.inset-y-0.right-0');
            
            if (email && email.includes('@')) {
                iconContainer.innerHTML = loadingIcon;
                
                emailCheckTimeout = setTimeout(() => {
                    fetch(`/check-email?email=${encodeURIComponent(email)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.exists) {
                                // Email exists
                                this.setCustomValidity('This email is already registered');
                                iconContainer.innerHTML = '<i class="fas fa-exclamation-circle text-red-500"></i>';
                                this.classList.add('border-red-300');
                                this.classList.remove('border-green-300');
                                
                                // Show error message
                                let errorMsg = this.parentElement.parentElement.querySelector('.text-red-600');
                                if (!errorMsg) {
                                    errorMsg = document.createElement('p');
                                    errorMsg.className = 'mt-1 text-sm text-red-600';
                                    this.parentElement.parentElement.appendChild(errorMsg);
                                }
                                errorMsg.textContent = 'This email is already registered';
                            } else {
                                // Email is available
                                this.setCustomValidity('');
                                iconContainer.innerHTML = '<i class="fas fa-check-circle text-green-500"></i>';
                                this.classList.remove('border-red-300');
                                this.classList.add('border-green-300');
                                
                                // Remove error message if exists
                                const errorMsg = this.parentElement.parentElement.querySelector('.text-red-600');
                                if (errorMsg) errorMsg.remove();
                            }
                        })
                        .catch(error => {
                            console.error('Error checking email:', error);
                        });
                }, 500); // Debounce time of 500ms
            }
        });
    });
</script>
@endsection
