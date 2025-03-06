<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use Illuminate\Http\Request;

use App\Models\Student;
use App\Models\Subject;


class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $enrollments = Enrollment::with('student', 'subject')->get();

        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('enrollments.create', compact('students', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|in:1st,2nd',
            'school_year' => 'required|string'
        ]);

        try {
            // Check for duplicate enrollment
            $existingEnrollment = Enrollment::where('student_id', $request->student_id)
                ->where('subject_id', $request->subject_id)
                ->where('semester', $request->semester)
                ->where('school_year', $request->school_year)
                ->first();

            if ($existingEnrollment) {
                return back()
                    ->with('error', 'Student is already enrolled in this subject for the selected semester.')
                    ->withInput();
            }

            // Check total units for the semester
            $currentUnits = Enrollment::where('student_id', $request->student_id)
                ->where('semester', $request->semester)
                ->where('school_year', $request->school_year)
                ->join('subjects', 'enrollments.subject_id', '=', 'subjects.id')
                ->sum('subjects.units');

            $newSubjectUnits = Subject::find($request->subject_id)->units;

            if (($currentUnits + $newSubjectUnits) > 30) {
                return back()
                    ->with('error', 'Maximum units (30) for the semester would be exceeded.')
                    ->withInput();
            }

            Enrollment::create($request->all());

            return redirect()->route('enrollments.index')
                ->with('success', 'Enrollment created successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Unable to create enrollment. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Enrollment $enrollment)
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('enrollments.edit', compact('enrollment', 'students', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|in:1st,2nd',
            'school_year' => ['required', 'regex:/^\d{4}-\d{4}$/'], // Ensure format like 2022-2023
        ]);

        $enrollment->update($validated);
        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')
            ->with('success', 'Enrollment deleted successfully');
    }
}
