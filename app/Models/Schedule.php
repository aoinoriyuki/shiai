<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    /** @use HasFactory<\Database\Factories\ScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'team_id',
        'date',
        'hour',
        'status',
    ];

    public function team()
    {
        return $this->belongsTo(team::class);
    }
}
