<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetitionRequest extends Model
{
    use HasFactory;

    protected $table = 'competition_requests';

    protected $fillable = [
        'user_id',
        'competition_id',
        'request_verified',
    ];

    protected $primaryKey = 'request_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class, 'competition_id', 'competition_id');
    }
}
