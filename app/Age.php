<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    public function profile(){
        
        return $this-> hasMany('App\Profile');
    }
}
