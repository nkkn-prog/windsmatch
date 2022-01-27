<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function profile()
    {
        return $this-> belongsTo('App\Profile');
    }
}
