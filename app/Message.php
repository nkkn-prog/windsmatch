<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'id',
        'send',
        'receive', 
        'message',
       
    ];
    
    public function user(){
        return $this->belongsTo('App/Message');
    }
    
    public function like(){
        return $this->belongsTo('App/Like');
    }
}
