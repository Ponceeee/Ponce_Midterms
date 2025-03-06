@extends('layouts.app')

@section('content')
<div class="py-6 px-4 sm:px-6 lg:px-8">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-6 sm:p-8 mb-6 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold mb-2">Account Pending Approval</h1>
                <p class="text-yellow-100">Please wait while we verify your account</p>
            </div>
            <div class="bg-yellow-400/30 px-4 py-2 rounded-lg">
                <i class="fas fa-clock text-white"></i>
            </div>
        </div>
    </div>

    <!-- Welcome Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex items-center mb-4">
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-user text-blue-600 text-xl"></i>
            </div>
            <h2 class="ml-3 text-xl font-semibold text-gray-900">Welcome, {{ Auth::user()->name }}!</h2>
        </div>
        <p class="text-gray-600">Your account is currently pending administrator approval.</p>
    </div>

    <!-- Info Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- What's Next Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-4">
                <div class="bg-indigo-100 rounded-full p-3">
                    <i class="fas fa-info-circle text-indigo-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">What's Next?</h3>
            </div>
            <p class="text-gray-600">Please wait while an administrator reviews your registration. This process may take some time.</p>
        </div>

        <!-- After Approval Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-4">
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">After Approval</h3>
            </div>
            <p class="text-gray-600">You will be able to access your student dashboard once your account has been approved.</p>
        </div>

        <!-- Need Help Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center mb-4">
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-question-circle text-purple-600 text-xl"></i>
                </div>
                <h3 class="ml-3 text-lg font-semibold text-gray-900">Need Help?</h3>
            </div>
            <p class="text-gray-600">If you have any questions, please contact the administrator.</p>
        </div>
    </div>
</div>

<!-- Add Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection 