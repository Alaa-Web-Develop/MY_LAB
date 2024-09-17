<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorUser extends User implements MustVerifyEmail
{
    use HasFactory,Notifiable;

    protected $guard='doctor';


    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'phone_number',
        'status',
    ];

}
