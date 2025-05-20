<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPeriod extends Model
{
    use HasFactory;

    protected $table = 'student_periods';

    protected $primaryKey = 'student_period_id';

    protected $fillable = [
        'period_id',
        'detail_student_id',
        'ipk',
    ];

    public function period()
    {
        return $this->belongsTo(Period::class, 'period_id', 'period_id');
    }

    public function detailStudent()
    {
        return $this->belongsTo(DetailStudent::class, 'detail_student_id', 'detail_student_id');
    }
}
