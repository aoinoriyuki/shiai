<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'host_team_id',
        'guest_team_id',
        'date',
        'hour',
    ];

    public function hostTeam()
    {
        return $this->belongsTo(team::class, 'host_team_id');
    }

    public function guestTeam()
    {
        return $this->belongsTo(team::class, 'guest_team_id');
    }
}
