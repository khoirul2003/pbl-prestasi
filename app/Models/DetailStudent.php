<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStudent extends Model
{
    use HasFactory;

    protected $table = 'detail_students';

    protected $fillable = [
        'user_id',
        'academic_year_id',
        'study_program_id',
        'detail_student_nim',
        'detail_student_gender',
        'detail_student_dob',
        'detail_student_address',
        'detail_student_phone_no',
        'detail_student_email',
        'detail_student_photo',
    ];

    protected $primaryKey = 'detail_student_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class, 'study_program_id', 'study_program_id');
    }

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id', 'academic_year_id');
    }

    public function studentSkills()
    {
        return $this->hasMany(StudentSkill::class, 'detail_student_id', 'detail_student_id');
    }

    public function studentPeriods()
    {
        return $this->hasMany(StudentPeriod::class, 'detail_student_id', 'detail_student_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(DetailSupervisor::class, 'supervisor_id', 'detail_supervisor_id');
    }
}
