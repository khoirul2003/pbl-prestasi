<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $table = 'study_programs';

    protected $fillable = [
        'major_id',
        'study_program_name',
    ];

    protected $primaryKey = 'study_program_id';

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id', 'major_id');
    }
}
