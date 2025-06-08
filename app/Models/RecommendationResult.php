<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationResult extends Model
{
    use HasFactory;

    protected $table = 'recommendation_results';

    protected $primaryKey = 'recommendation_result_id';

    protected $fillable = [
        'user_id', // ini untuk student, users berelasi ke detail_students nanti akan mengambil detail_student_id dan detail_student_name
        'competition_id',
        'detail_supervisor_id', // ini untu supervisor
        'recommendation_result_score',
        'detail_student_id', // ini untu supervisor
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id', 'competition_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(DetailSupervisor::class, 'detail_supervisor_id', 'detail_supervisor_id');
    }

    public function detailStudent()
    {
        return $this->belongsTo(DetailStudent::class, 'detail_student_id', 'detail_student_id');
    }
}
