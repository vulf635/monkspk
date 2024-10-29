<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Peers extends Model
{
    protected $fillable = [
        'code',
        'offer',
        'answer',
        "application",
        "session"
    ];
}