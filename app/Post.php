<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = array('title','body','user_id','post_image');

    protected function getTitleAttribute($value)
    {
    	return ucwords($value);
    }

    protected function getBodyAttribute($value)
    {
    	return ucfirst($value);
    }

    protected function settitleAttribute($value)
    {
    	$this->attributes['title'] = strtolower($value);
    }
}
