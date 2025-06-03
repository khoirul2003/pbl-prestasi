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
        'user_id',
        'competition_id',
        'detail_supervisor_id',
        'recommendation_result_score',
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
}
