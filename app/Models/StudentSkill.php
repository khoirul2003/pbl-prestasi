<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSkill extends Model
{
    use HasFactory;

    protected $table = 'student_skills';
    
    protected $primaryKey = 'student_skill_id';

    protected $fillable = [
        'detail_student_id',
        'skill_id',
    ];

    public function detailStudent()
    {
        return $this->belongsTo(DetailStudent::class, 'detail_student_id', 'detail_student_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'skill_id');
    }
}
