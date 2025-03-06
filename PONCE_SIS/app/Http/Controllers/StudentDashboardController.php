<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->status === 'not_added_as_student') {
            return view('students.pending');
        }

        // Get the authenticated student's record
        $student = Student::where('email', Auth::user()->email)->first();
        
        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        $grades = Grade::with('subject')
            ->where('student_id', $student->id)
            ->get();

        // Calculate GWA
        $totalUnits = 0;
        $totalWeightedGrades = 0;

        foreach ($grades as $grade) {
            if ($grade->average) {
                $totalUnits += $grade->subject->units;
                $totalWeightedGrades += ($grade->average * $grade->subject->units);
            }
        }

        $gwa = $totalUnits > 0 ? number_format($totalWeightedGrades / $totalUnits, 2) : 0;

        return view('students.dashboard', compact('grades', 'student', 'gwa'));
    }
}
