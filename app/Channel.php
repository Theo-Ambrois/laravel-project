<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function chat(){

        return $this->hasMany(Chat::class);
        
    }
}
