<aside class="bg-gray-800 w-64 min-h-screen fixed left-0 top-0 overflow-y-auto">
    <div class="py-4">
        <!-- Logo/Brand -->
        <div class="px-6 py-3">
            <h1 class="text-white text-xl font-bold">Student Portal</h1>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-5 px-3">
            @if(auth()->user()->role === 'admin')
                <!-- Admin Menu Items -->
                <div class="mb-2 px-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Administration
                    </p>
                </div>

                <!-- Dashboard -->
                <a href="{{ route('admin-dashboard') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('admin-dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-home w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Manage Students -->
                <a href="{{ route('students.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('students.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-user-graduate w-5 h-5 mr-3"></i>
                    <span>Manage Students</span>
                </a>

                <!-- Manage Subjects -->
                <a href="{{ route('subjects.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('subjects.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-book w-5 h-5 mr-3"></i>
                    <span>Manage Subjects</span>
                </a>

                <!-- Manage Enrollments -->
                <a href="{{ route('enrollments.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('enrollments.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-user-plus w-5 h-5 mr-3"></i>
                    <span>Manage Enrollments</span>
                </a>

                <!-- Manage Grades -->
                <a href="{{ route('grades.index') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('grades.*') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-graduation-cap w-5 h-5 mr-3"></i>
                    <span>Manage Grades</span>
                </a>
            @else
                <!-- Student Menu - Only Dashboard -->
                <a href="{{ route('student-dashboard') }}" 
                   class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('student-dashboard') ? 'bg-gray-700 text-white' : '' }}">
                    <i class="fas fa-home w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
            @endif

            <!-- Common Menu Items -->
            <div class="mt-4 mb-2 px-4">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    Account
                </p>
            </div>

            <!-- Profile -->
            <a href="{{ route('profile.edit') }}" 
               class="flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors {{ request()->routeIs('profile.*') ? 'bg-gray-700 text-white' : '' }}">
                <i class="fas fa-user-circle w-5 h-5 mr-3"></i>
                <span>Profile</span>
            </a>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center px-4 py-3 text-gray-300 hover:bg-gray-700 hover:text-white rounded-lg transition-colors">
                    <i class="fas fa-sign-out-alt w-5 h-5 mr-3"></i>
                    <span>Logout</span>
                </button>
            </form>
        </nav>
    </div>
</aside>
