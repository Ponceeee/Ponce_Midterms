<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Providers\AppServiceProvider;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Http\Request;
use App\Models\Subject;


Route::get('/', function () {
    return view('welcome');
});



// Admin Dashboard (Only accessible to Admins)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
    Route::resource('students', StudentController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('grades', GradeController::class);
    Route::post('/students/approve/{user}', [StudentController::class, 'approve'])->name('students.approve');
    Route::delete('/students/decline/{user}', [StudentController::class, 'decline'])->name('students.decline');
    Route::get('/students/{student}/view', [StudentController::class, 'show'])->name('students.show');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('grades', GradeController::class)->except(['index', 'show']);
});

// Student Dashboard (Only accessible to Students)
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student-dashboard', [StudentDashboardController::class, 'index'])->name('student-dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/check-email', function (Request $request) {
    $email = $request->input('email');
    $exists = \App\Models\User::where('email', $email)->exists();
    return response()->json(['exists' => $exists]);
})->name('check-email');

Route::get('/check-subject', function (Request $request) {
    $code = $request->input('code');
    $name = $request->input('name');
    $exists = \App\Models\Subject::where('code', $code)
        ->orWhere('name', $name)
        ->exists();
    return response()->json([
        'exists' => $exists,
        'message' => $exists ? 'Subject with this code or name already exists.' : null
    ]);
})->name('check-subject');

Route::get('/check-enrollment', function (Request $request) {
    $studentId = $request->input('student_id');
    $subjectId = $request->input('subject_id');
    
    $exists = \App\Models\Enrollment::where('student_id', $studentId)
        ->where('subject_id', $subjectId)
        ->exists();
        
    return response()->json([
        'exists' => $exists,
        'message' => $exists ? 'This student is already enrolled in this subject.' : null
    ]);
})->name('check-enrollment');

Route::get('/get-enrolled-subjects/{student}/{semester}', function ($student, $semester) {
    $subjects = Subject::whereHas('enrollments', function($query) use ($student, $semester) {
        $query->where('student_id', $student)
              ->where('semester', $semester);
    })->get();
    
    return response()->json(['subjects' => $subjects]);
})->name('get-enrolled-subjects');

require __DIR__.'/auth.php';
