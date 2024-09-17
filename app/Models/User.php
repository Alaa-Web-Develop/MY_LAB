<?php

namespace App\Models;



use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    //protected $guard='web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'first_login'
    ];

    //check it the first login
    public function isFirstLogin()
    {
return is_null($this->first_login);

    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    //Rel
    public function doctor()
    {
        return $this->hasOne(Doctor::class,'user_id','id')->withDefault();
    }

     //Rel
     public function courier()
     {
         return $this->hasOne(Courier::class,'user_id','id')->withDefault();
     }


    public function labBranch()
    {
        return $this->hasOne(LabBranch::class,'user_id','id')->withDefault();
    }
}
