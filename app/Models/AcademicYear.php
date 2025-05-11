<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $table = 'academic_years';

    protected $fillable = [
        'academic_year',
        'start_date',
        'end_date',
    ];

    protected $primaryKey = 'academic_year_id';


    public function periods()
    {
        return $this->hasMany(Period::class, 'academic_year_id', 'academic_year_id');
    }
}
