<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo', 'website'];

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'sponsor_tournament');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'sponsor_team');
    }
}