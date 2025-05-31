<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreUniversityAchievement extends Model
{
    use HasFactory;

    protected $table = 'pre_university_achievements';

    protected $primaryKey = 'pre_university_achievement_id';

    protected $fillable = [
        'user_id',
        'category_id',
        'pre_university_achievement_title',
        'pre_university_achievement_description',
        'pre_university_achievement_ranking',
        'pre_university_achievement_level',
        'pre_university_achievement_document',
    ];

 
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
