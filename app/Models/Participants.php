<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participants extends Model
{
    protected $table = 'participants';

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'face_images' => 'array',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendances::class, 'participant_id');
    }
}
