@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-orange-600 to-red-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Add Grade</h1>
                <p class="text-orange-100">Create a new student grade</p>
            </div>
            <a href="{{ route('grades.index') }}" 
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
                <div class="bg-orange-100 rounded-full p-3">
                    <i class="fas fa-graduation-cap text-orange-600 text-xl"></i>
                </div>
                <h2 class="ml-3 text-lg font-semibold text-gray-900">Grade Details</h2>
            </div>
        </div>

        <form method="POST" action="{{ route('grades.store') }}" class="p-6 space-y-6">
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
                                class="w-full px-4 py-2.5 rounded-lg border @error('student_id') border-red-300 @else border-gray-300 @enderror"
                                required>
                            <option value="">Select Student</option>
                            @foreach($enrolledStudents as $student)
                                <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->student_id }} - {{ $student->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Subject -->
                <div class="form-group">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Subject <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="subject_id" 
                                id="subject_id"
                                class="w-full px-4 py-2.5 rounded-lg border @error('subject_id') border-red-300 @else border-gray-300 @enderror"
                                required>
                            <option value="">Select Subject</option>
                        </select>
                    </div>
                </div>

                <!-- Semester -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Semester <span class="text-red-500">*</span>
                    </label>
                    <select name="semester" 
                            id="semester"
                            class="w-full px-4 py-2.5 rounded-lg border @error('semester') border-red-300 @else border-gray-300 @enderror"
                            required>
                        <option value="">Select Semester</option>
                        <option value="1st" {{ old('semester') == '1st' ? 'selected' : '' }}>First Semester</option>
                        <option value="2nd" {{ old('semester') == '2nd' ? 'selected' : '' }}>Second Semester</option>
                    </select>
                    @error('semester')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Midterm Grade -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Midterm Grade <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="midterm" 
                           value="{{ old('midterm') }}"
                           class="w-full px-4 py-2.5 rounded-lg border @error('midterm') border-red-300 @else border-gray-300 @enderror"
                           step="0.01" 
                           min="1.00" 
                           max="5.00" 
                           required>
                    @error('midterm')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Final Grade -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Final Grade <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="final" 
                           value="{{ old('final') }}"
                           class="w-full px-4 py-2.5 rounded-lg border @error('final') border-red-300 @else border-gray-300 @enderror"
                           step="0.01" 
                           min="1.00" 
                           max="5.00" 
                           required>
                    @error('final')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" 
                              class="w-full px-4 py-2.5 rounded-lg border @error('description') border-red-300 @else border-gray-300 @enderror"
                              rows="3" 
                              required>{{ old('description') }}</textarea>
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
                    Add Grade
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<!-- Add this script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentSelect = document.getElementById('student_id');
    const subjectSelect = document.getElementById('subject_id');
    const semesterSelect = document.getElementById('semester');

    function loadEnrolledSubjects() {
        const studentId = studentSelect.value;
        const semester = semesterSelect.value;
        
        if (studentId && semester) {
            // Show loading state
            subjectSelect.innerHTML = '<option value="">Loading subjects...</option>';
            subjectSelect.disabled = true;

            fetch(`/get-enrolled-subjects/${studentId}/${semester}`)
                .then(response => response.json())
                .then(data => {
                    subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                    if (data.subjects.length === 0) {
                        subjectSelect.innerHTML = '<option value="">No enrolled subjects for this semester</option>';
                    } else {
                        data.subjects.forEach(subject => {
                            subjectSelect.innerHTML += `
                                <option value="${subject.id}">
                                    ${subject.code} - ${subject.name}
                                </option>`;
                        });
                    }
                    subjectSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error loading subjects:', error);
                    subjectSelect.innerHTML = '<option value="">Error loading subjects</option>';
                    subjectSelect.disabled = false;
                });
        } else {
            subjectSelect.innerHTML = '<option value="">Select Student and Semester first</option>';
            subjectSelect.disabled = true;
        }
    }

    // Load subjects when either student or semester changes
    studentSelect.addEventListener('change', loadEnrolledSubjects);
    semesterSelect.addEventListener('change', loadEnrolledSubjects);

    // Initial load if values are pre-selected
    if (studentSelect.value && semesterSelect.value) {
        loadEnrolledSubjects();
    }
});
</script>
@endsection
