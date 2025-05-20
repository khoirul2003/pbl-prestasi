<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $table = 'study_programs';

    protected $fillable = [
        'department_id',
        'study_program_name',
    ];

    protected $primaryKey = 'study_program_id';

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}
