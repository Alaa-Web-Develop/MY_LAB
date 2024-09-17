<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LabUser extends User implements MustVerifyEmail
{
    use HasFactory,Notifiable;

    protected $guard='lab';
    
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone_number',
        'status',
    ];

}
