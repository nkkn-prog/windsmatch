<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    
    protected $fillable = [
        'id',
        'user_id',
        'nickname',
        'sex',
        'age',
        'prefecture_id',
        'musical_experience',
        'message',
        'image_id'
    ];
    
    public function user()
    {
        return $this-> belongsTo('App\User');
    }
    
    public function age(){
        
        return $this-> belongsTo('App\Age');
    }
    
    public function instruments()
    {
        return $this-> belongsToMany('App\Instrument');
    }
    
     public function genres()
    {
        return $this-> belongsToMany('App\Genre');
    }
    
    public function prefecture()
    {
        return $this-> belongsTo('App\Prefecture');
    }
    
    public function image()
    {
        return $this-> belongsTo('App\Image');
    }
    
    public function scopeSexEqual($query, $str)
    {
        return $query->where('sex', $str);
    }
    
    public function scopePrefectureEqual($query, $int)
    {
        return $query->where('prefecture_id', $int);
    }
    
}