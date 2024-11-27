<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'height', 'position', 'goals', 'assists', 'yellow_cards', 'red_cards'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function playerDetail()
{
    return $this->hasOne(PlayerDetail::class);
}
}
