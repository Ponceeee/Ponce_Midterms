@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Student Profile</h1>
                <p class="text-blue-100">View detailed student information</p>
            </div>
            <a href="{{ route('students.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-white/20 rounded-lg hover:bg-white/30 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Personal Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-6">
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-user text-blue-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">Personal Information</h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500">Student ID</span>
                    <span class="text-sm text-gray-900">{{ $student->student_id ?? 'Not assigned' }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500">Name</span>
                    <span class="text-sm text-gray-900">{{ $student->name }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500">Email</span>
                    <span class="text-sm text-gray-900">{{ $student->email }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500">Phone</span>
                    <span class="text-sm text-gray-900">{{ $student->phone }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500">Age</span>
                    <span class="text-sm text-gray-900">{{ $student->age }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm font-medium text-gray-500">Address</span>
                    <span class="text-sm text-gray-900">{{ $student->address }}</span>
                </div>
            </div>
        </div>

        <!-- Academic Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-6">
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">Academic Information</h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500">Course</span>
                    <span class="text-sm text-gray-900">{{ $student->course }}</span>
                </div>
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500">Year Level</span>
                    <span class="text-sm text-gray-900">{{ $student->year_level }}</span>
                </div>
                @if($student->user)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-500">Account Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $student->user->status === 'added_as_student' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($student->user->status) }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm font-medium text-gray-500">Last Login</span>
                        <span class="text-sm text-gray-900">
                            {{ $student->user->last_login_at ? \Carbon\Carbon::parse($student->user->last_login_at)->format('M d, Y h:i A') : 'Never' }}
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Enrollment Information Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-6">
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-book text-purple-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">Enrollment Information</h3>
            </div>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center py-3 border-b border-gray-100">
                    <span class="text-sm font-medium text-gray-500">Total Enrolled Subjects</span>
                    <span class="text-sm text-gray-900">{{ $student->enrollments()->count() }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm font-medium text-gray-500">Current Semester Subjects</span>
                    <span class="text-sm text-gray-900">{{ $student->enrollments()->where('semester', 'current')->count() }}</span>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 pt-6 border-t border-gray-100">
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('students.edit', $student) }}" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
