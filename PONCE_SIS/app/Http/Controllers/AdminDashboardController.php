<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalStudents = Student::count();
        $totalSubjects = Subject::count();
        $totalEnrollments = Enrollment::count();
        $totalGrades = Grade::count();

        // Get recent activities
        $recentActivities = collect();

        // Recent student registrations
        $recentStudents = User::where('role', 'student')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($user) {
                return [
                    'type' => 'registration',
                    'icon' => 'fa-user-plus',
                    'color' => 'blue',
                    'message' => 'New student registration: ' . $user->name,
                    'time' => $user->created_at
                ];
            });

        // Recent enrollments
        $recentEnrollments = Enrollment::with('student')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($enrollment) {
                return [
                    'type' => 'enrollment',
                    'icon' => 'fa-user-graduate',
                    'color' => 'purple',
                    'message' => 'New enrollment: ' . $enrollment->student->name,
                    'time' => $enrollment->created_at
                ];
            });

        // Recent grades
        $recentGrades = Grade::with(['student', 'subject'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function($grade) {
                return [
                    'type' => 'grade',
                    'icon' => 'fa-star',
                    'color' => 'yellow',
                    'message' => 'New grade added for ' . $grade->student->name,
                    'time' => $grade->created_at
                ];
            });

        // Merge all activities and sort by time
        $recentActivities = $recentStudents->concat($recentEnrollments)
            ->concat($recentGrades)
            ->sortByDesc('time')
            ->take(10);

        return view('admin.index', compact(
            'totalStudents',
            'totalSubjects',
            'totalEnrollments',
            'totalGrades',
            'recentActivities'
        ));
    }
} 