<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorSkill extends Model
{
    use HasFactory;


    protected $table = 'supervisor_skills';

    protected $primaryKey = 'supervisor_skill_id';

    protected $fillable = [
        'detail_supervisor_id',
        'skill_id',
    ];

    public function detailStudent()
    {
        return $this->belongsTo(DetailSupervisor::class, 'detail_supervisor_id', 'detail_supervisor_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id', 'skill_id');
    }
}
