<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'has_event', 'event_start', 'event_end', 'team_id'];

    protected $table = 'stadiums';

    // Usa casts para convertir los campos automáticamente a Carbon
    protected $casts = [
        'event_start' => 'datetime',
        'event_end' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
