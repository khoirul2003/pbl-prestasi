<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSupervisor extends Model
{
    use HasFactory;

    protected $table = 'detail_supervisors';

    protected $fillable = [
        'user_id',
        'department_id',
        'detail_supervisor_nip',
        'detail_supervisor_gender',
        'detail_supervisor_dob',
        'detail_supervisor_address',
        'detail_supervisor_phone_no',
        'detail_supervisor_email',
        'detail_supervisor_photo',
    ];

    protected $primaryKey = 'detail_supervisor_id';

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function detailSupervisor()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
