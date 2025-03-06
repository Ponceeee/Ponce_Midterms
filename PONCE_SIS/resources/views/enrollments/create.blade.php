@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-600 to-teal-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Add Enrollment</h1>
                <p class="text-green-100">Create a new student enrollment</p>
            </div>
            <a href="{{ route('enrollments.index') }}" 
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
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-user-graduate text-green-600 text-xl"></i>
                </div>
                <h2 class="ml-3 text-lg font-semibold text-gray-900">Enrollment Details</h2>
            </div>
        </div>

        <form id="enrollmentForm" action="{{ route('enrollments.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Student -->
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Student <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="student_id" 
                                id="student_id"
                                class="w-full px-4 py-2.5 rounded-lg border @error('student_id') border-red-300 @else border-gray-300 @enderror
                                       focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                            <option value="">Select Student</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->student_id }} - {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                        @enderror
                    </div>
                    @error('student_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                    <select name="subject_id" 
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Semester -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <select name="semester" 
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                        required>
                        <option value="" disabled selected>Select Semester</option>
                        <option value="1st" {{ old('semester') == '1st' ? 'selected' : '' }}>1st</option>
                        <option value="2nd" {{ old('semester') == '2nd' ? 'selected' : '' }}>2nd</option>
                    </select>
                    @error('semester')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- School Year -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">School Year</label>
                    <input type="text" name="school_year" 
                        value="{{ old('school_year') }}" 
                        placeholder="2022-2023"
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        required>
                    @error('school_year')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                <a href="{{ route('enrollments.index') }}" 
                   class="px-6 py-2.5 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('enrollmentForm');
    const studentSelect = document.getElementById('student_id');
    const subjectSelect = document.getElementById('subject_id');
    const semesterSelect = document.getElementById('semester');
    let checkTimeout;

    function checkEnrollmentExists() {
        clearTimeout(checkTimeout);
        
        const studentId = studentSelect.value;
        const subjectId = subjectSelect.value;
        const semester = semesterSelect.value;
        
        if (!studentId || !subjectId || !semester) return;

        // Add loading indicator
        const loadingIcon = '<i class="fas fa-spinner fa-spin text-gray-400"></i>';
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.innerHTML = loadingIcon + ' Checking...';
        submitBtn.disabled = true;

        checkTimeout = setTimeout(() => {
            fetch(`/check-enrollment?student_id=${studentId}&subject_id=${subjectId}&semester=${semester}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        // Show error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Duplicate Enrollment',
                            text: data.message,
                            confirmButtonColor: '#3085d6'
                        });
                        submitBtn.disabled = true;
                    } else {
                        // Check units limit
                        fetch(`/check-units-limit?student_id=${studentId}&subject_id=${subjectId}&semester=${semester}`)
                            .then(response => response.json())
                            .then(unitsData => {
                                if (unitsData.exceeds_limit) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Units Limit Exceeded',
                                        text: 'Maximum units (30) for the semester would be exceeded.',
                                        confirmButtonColor: '#3085d6'
                                    });
                                    submitBtn.disabled = true;
                                } else {
                                    submitBtn.disabled = false;
                                }
                            });
                    }
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Create Enrollment';
                })
                .catch(error => {
                    console.error('Error checking enrollment:', error);
                    submitBtn.innerHTML = '<i class="fas fa-save mr-2"></i>Create Enrollment';
                    submitBtn.disabled = false;
                });
        }, 500);
    }

    // Add event listeners
    studentSelect.addEventListener('change', checkEnrollmentExists);
    subjectSelect.addEventListener('change', checkEnrollmentExists);
    semesterSelect.addEventListener('change', checkEnrollmentExists);

    // Form submission handling
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) {
                firstInvalid.focus();
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
