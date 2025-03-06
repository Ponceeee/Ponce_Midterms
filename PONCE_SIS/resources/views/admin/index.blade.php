@extends('layouts.app')
@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-blue-100">Here's what's happening in your system today.</p>
            </div>
            <div class="hidden sm:block">
                <span class="text-sm bg-blue-400/30 px-4 py-2 rounded-lg">
                    {{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach(['Students' => $totalStudents, 'Subjects' => $totalSubjects, 'Enrollments' => $totalEnrollments, 'Grades' => $totalGrades] as $label => $count)
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-lg transition-shadow">
                <div class="flex items-center">
                    <div class="bg-blue-100 rounded-lg p-3">
                        <i class="fas fa-{{ $label === 'Students' ? 'users' : ($label === 'Subjects' ? 'book' : 'user-graduate') }} text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total {{ $label }}</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1" x-text="$count ?? '...'">{{ $count }}</h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Quick Actions Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Quick Actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('students.create') }}" class="flex items-center p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                <div class="bg-blue-100 rounded-lg p-2">
                    <i class="fas fa-user-plus text-blue-600"></i>
                </div>
                <span class="ml-3 font-medium text-blue-900">Add New Student</span>
            </a>

            <a href="{{ route('subjects.create') }}" class="flex items-center p-4 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                <div class="bg-green-100 rounded-lg p-2">
                    <i class="fas fa-book-medical text-green-600"></i>
                </div>
                <span class="ml-3 font-medium text-green-900">Add New Subject</span>
            </a>

            <a href="{{ route('enrollments.create') }}" class="flex items-center p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition-colors">
                <div class="bg-purple-100 rounded-lg p-2">
                    <i class="fas fa-user-plus text-purple-600"></i>
                </div>
                <span class="ml-3 font-medium text-purple-900">New Enrollment</span>
            </a>

            <a href="{{ route('grades.create') }}" class="flex items-center p-4 bg-orange-50 rounded-xl hover:bg-orange-100 transition-colors">
                <div class="bg-orange-100 rounded-lg p-2">
                    <i class="fas fa-plus-circle text-orange-600"></i>
                </div>
                <span class="ml-3 font-medium text-orange-900">Add New Grade</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">Recent Activity</h2>
        </div>
        <div class="space-y-4">
            @forelse($recentActivities as $activity)
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="bg-{{ $activity['color'] }}-100 rounded-full p-2">
                        <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">{{ $activity['message'] }}</p>
                        <p class="text-sm text-gray-500">{{ $activity['time']->diffForHumans() }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 py-4">
                    No recent activities
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
