<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupGameSignup extends Model
{
    protected $fillable = ['user_id', 'pickup_game_id', 'comment'];
    protected $dates = ['created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pickupGame()
    {
        return $this->belongsTo(PickupGame::class);
    }
} 