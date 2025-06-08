<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $table = 'achievements';

    protected $fillable = [
        'user_id',
        'category_id',
        'achievement_title',
        'achievement_description',
        'achievement_ranking',
        'achievement_level',
        'achievement_document',
        'achievement_verified',
        'achievement_reject_description'
    ];

    protected $primaryKey = 'achievement_id';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }
}
