<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Enrollment;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = Grade::with(['student', 'subject'])->get();
        return view('grades.index', compact('grades'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get only students who are enrolled in subjects
        $enrolledStudents = Student::whereHas('enrollments')->get();
        
        // Get only subjects that have enrolled students
        $activeSubjects = Subject::whereHas('enrollments')->get();

        return view('grades.create', compact('enrolledStudents', 'activeSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'semester' => 'required|in:1st,2nd',
            'midterm' => 'required|numeric|min:1|max:5',
            'final' => 'required|numeric|min:1|max:5',
            'description' => 'required|string',
        ]);

        try {
            // Check if student is enrolled in this subject
            $enrollment = Enrollment::where('student_id', $request->student_id)
                ->where('subject_id', $request->subject_id)
                ->where('semester', $request->semester)
                ->first();

            if (!$enrollment) {
                return back()->with('error', 'Cannot add grade. Student is not enrolled in this subject for the selected semester.')
                            ->withInput();
            }

            // Check if grade already exists
            $existingGrade = Grade::where('student_id', $request->student_id)
                ->where('subject_id', $request->subject_id)
                ->where('semester', $request->semester)
                ->first();

            if ($existingGrade) {
                return back()->with('error', 'Grade already exists for this student in this subject for the selected semester.')
                            ->withInput();
            }

            // Calculate average and remarks
            $average = ($request->midterm + $request->final) / 2;
            $us_grade = $this->calculateGradeRemarks($average);

            // Create the grade
            Grade::create([
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'semester' => $request->semester,
                'midterm' => $request->midterm,
                'final' => $request->final,
                'description' => $request->description,
                'average' => $average,
                'us_grade' => $us_grade
            ]);

            return redirect()->route('grades.index')
                ->with('success', 'Grade added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to add grade. Please try again.')
                        ->withInput();
        }
    }

    private function calculateGradeRemarks($average)
    {
        return $average <= 3.00 ? 'Passed' : 'Failed';
    }
    
    private function calculateSemesterTotal($student_id, $semester)
    {
        $grades = Grade::where('student_id', $student_id)
            ->where('semester', $semester)
            ->whereNotNull('average')
            ->pluck('average');
    
        return $grades->count() > 0 ? $grades->sum() / $grades->count() : null;
    }
    
    


    /**
     * Display the specified resource.
     */
    public function show(Grade $grade)
    {
        return view('grades.show', compact('grade'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grade $grade)
    {
        $students = Student::all();
        $subjects = Subject::all();
        return view('grades.edit', compact('grade', 'students', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grade $grade)
    {
        $validator = \Validator::make($request->all(), [
            'midterm' => 'required|numeric|min:1|max:5',
            'final' => 'required|numeric|min:1|max:5',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $grade->midterm = $request->midterm;
            $grade->final = $request->final;
            $grade->description = $request->description;
            $grade->average = ($request->midterm + $request->final) / 2;
            $grade->us_grade = $this->calculateGradeRemarks($grade->average);
            $grade->save();

            return redirect()->route('grades.index')
                ->with('success', 'Grade updated successfully.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to update grade.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')
            ->with('success', 'Grade deleted successfully');
    }

    private function getGradeDescription($numeric_grade)
    {
        if ($numeric_grade >= 1.00 && $numeric_grade <= 1.24) {
            return [1.00, "Passed"];
        } elseif ($numeric_grade >= 1.25 && $numeric_grade <= 1.49) {
            return [1.25, "Passed"];
        } elseif ($numeric_grade >= 1.50 && $numeric_grade <= 1.74) {
            return [1.50, "Passed"];
        } elseif ($numeric_grade >= 1.75 && $numeric_grade <= 1.99) {
            return [1.75, "Passed"];
        } elseif ($numeric_grade >= 2.00 && $numeric_grade <= 2.24) {
            return [2.00, "Passed"];
        } elseif ($numeric_grade >= 2.25 && $numeric_grade <= 2.49) {
            return [2.25, "Passed",];
        } elseif ($numeric_grade >= 2.50 && $numeric_grade <= 2.74) {
            return [2.50, "Passed"];
        } elseif ($numeric_grade >= 2.75 && $numeric_grade <= 2.99) {
            return [2.75, "Passed"];
        } elseif ($numeric_grade == 3.00) {
            return [3.00, "Pass"];
        } elseif ($numeric_grade > 3.00 && $numeric_grade <= 4.00) {
            return [4.00, "Conditional"];
        } else {
            return [5.00, "Failed"];
        }
    }
    
    private function updateSemesterTotal($student_id, $semester)
    {
        $grades = Grade::where('student_id', $student_id)
            ->where('semester', $semester)
            ->whereNotNull('average')
            ->pluck('average');
    
        if ($grades->count() > 0) {
            $semester_average = $grades->sum() / $grades->count();
        } else {
            $semester_average = null; // No grades available
        }
    
        if ($semester === '1st') {
            Grade::where('student_id', $student_id)
                ->update([
                    '1st_sem_total_grade' => $semester_average,
                    '2nd_sem_total_grade' => null  // Ensure 2nd semester is null
                ]);
        } else {
            Grade::where('student_id', $student_id)
                ->update([
                    '2nd_sem_total_grade' => $semester_average,
                    '1st_sem_total_grade' => null  // Ensure 1st semester is null
                ]);
        }
    }
    

}
