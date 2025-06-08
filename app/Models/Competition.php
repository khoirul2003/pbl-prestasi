<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;

    protected $table = 'competitions';

    protected $fillable = [
        'category_id',
        'competition_tittle',
        'competition_description',
        'competition_organizer',
        'competition_level',
        'competition_registration_start',
        'competition_registration_deadline',
        'competition_registration_link',
        'competition_document',
    ];

    protected $primaryKey = 'competition_id';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function competitionRequests()
    {
        return $this->hasMany(CompetitionRequest::class, 'competition_id', 'competition_id');
    }
}
