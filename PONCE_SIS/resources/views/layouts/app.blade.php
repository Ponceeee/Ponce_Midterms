<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
   
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="{{ asset('js/dashboard.js') }}"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!-- Add these in the head section -->
        <style>
            /* Argon Dashboard Theme Colors */
            :root {
                --primary: #5e72e4;
                --secondary: #8392ab;
                --info: #11cdef;
                --success: #2dce89;
                --warning: #fb6340;
                --danger: #f5365c;
                --light: #e9ecef;
                --dark: #344767;
            }

            /* Smooth transitions */
            * {
                transition: all 0.2s ease-in-out;
            }

            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }

            ::-webkit-scrollbar-track {
                background: #f8f9fa;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb {
                background: #8392ab;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #67748e;
            }

            /* Page Transitions */
            .page-transition {
                animation: pageTransition 0.3s ease-out;
            }

            @keyframes pageTransition {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </head>
    <body class="bg-gray-50">
        @include('layouts.sidebar')
        <div class="pl-64">
            <div class="min-h-screen bg-gray-100">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script href="{{ asset('js/custom.js') }}"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <script>
            document.getElementById('semester').addEventListener('change', function() {
                let semester = this.value;
                document.getElementById('midterm-section').style.display = (semester === '1st') ? 'block' : 'none';
                document.getElementById('final-section').style.display = (semester === '2nd') ? 'block' : 'none';
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#studentsTable').DataTable();
            });
        </script>
         <script>
            $(document).ready(function() {
                $('#subjectsTable').DataTable();
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#enrollmentsTable').DataTable();
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#gradesTable').DataTable();
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#usersTable').DataTable();
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#gradesDashboard').DataTable();
            });
        </script>
        @if(session('success'))
            <div class="fixed top-4 right-4 z-50">
                <x-alert type="success" :message="session('success')" />
            </div>
        @endif

        @if(session('error'))
            <div class="fixed top-4 right-4 z-50">
                <x-alert type="error" :message="session('error')" />
            </div>
        @endif

        @if(session('warning'))
            <div class="fixed top-4 right-4 z-50">
                <x-alert type="warning" :message="session('warning')" />
            </div>
        @endif

        @if(session('info'))
            <div class="fixed top-4 right-4 z-50">
                <x-alert type="info" :message="session('info')" />
            </div>
        @endif

        @if($errors->any())
            <div class="fixed top-4 right-4 z-50">
                <x-alert type="error" :message="'Please check the form for errors.'" />
            </div>
        @endif
    </body>
</html>