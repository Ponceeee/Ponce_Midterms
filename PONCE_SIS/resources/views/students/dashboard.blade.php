@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Student Dashboard</h1>
                <p class="text-blue-100">Welcome back, {{ Auth::user()->name }}!</p>
            </div>
            <div class="hidden sm:block">
                <span class="text-sm bg-white/20 px-4 py-2 rounded-lg">
                    {{ now()->format('l, F j, Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
        <!-- Enrolled Subjects -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-lg p-3">
                    <i class="fas fa-book-reader text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Enrolled Subjects</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $grades->groupBy('subject.name')->count() }}</h3>
                </div>
            </div>
        </div>

        <!-- Year Level -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-lg p-3">
                    <i class="fas fa-graduation-cap text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Year Level</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $student->year_level }}</h3>
                </div>
            </div>
        </div>

        <!-- Course -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-lg p-3">
                    <i class="fas fa-university text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Course</p>
                    <h3 class="text-lg font-bold text-gray-900 mt-1">{{ $student->course }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Grades -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-yellow-100 rounded-lg p-3">
                    <i class="fas fa-chart-line text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Grades</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $grades->count() }}</h3>
                </div>
            </div>
        </div>

        <!-- GWA -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="bg-red-100 rounded-lg p-3">
                    <i class="fas fa-star text-red-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Overall GWA</p>
                    <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($gwa, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Grades Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-lg font-semibold text-gray-900">Your Grades</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">1st Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">2nd Semester</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($grades->groupBy('subject.name') as $subjectName => $subjectGrades)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $subjectName }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ number_format($subjectGrades->where('semester', '1st')->first()->average ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ number_format($subjectGrades->where('semester', '2nd')->first()->average ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $subjectGrades->first()->us_grade === 'PASSED' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $subjectGrades->first()->us_grade }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
