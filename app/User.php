<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function messages(){

        return $this->hasMany(Chat::class);
        
    }
}
