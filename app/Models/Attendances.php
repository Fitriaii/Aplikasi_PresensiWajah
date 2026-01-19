<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendances extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'attendances_setting_id',
        'participant_id',
        'method',
        'attended_at',
    ];

    protected $casts = [
        'attended_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function participant()
    {
        return $this->belongsTo(Participants::class, 'participant_id');
    }

    public function attendanceSetting()
    {
        return $this->belongsTo(AttendanceSetting::class, 'attendances_setting_id');
    }

}
