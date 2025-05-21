<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id',
        'user_name',
        'user_username',
        'user_password',
    ];

    protected $primaryKey = 'user_id';

    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function detailSupervisor()
    {
        return $this->hasOne(DetailSupervisor::class, 'user_id', 'user_id');
    }

    public function detailStudent()
    {
        return $this->hasOne(DetailStudent::class, 'user_id', 'user_id');
    }
}
