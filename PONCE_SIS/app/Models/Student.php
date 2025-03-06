<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\User;

class Student extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'email',
        'phone',
        'address',
        'age',
        'status',
        'year_level',
        'course'
    ];

    protected $guarded = ['course'];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    // Get latest enrolled semester
    public function getLatestSemesterAttribute()
    {
        return $this->enrollments()->orderBy('created_at', 'desc')->first()?->semester ?? 'Not Enrolled';
    }

    // Get latest enrolled school year
    public function getLatestSchoolYearAttribute()
    {
        return $this->enrollments()->orderBy('created_at', 'desc')->first()?->school_year ?? 'N/A';
    }

}
