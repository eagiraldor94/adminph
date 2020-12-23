<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Minute extends Model
{
	protected $table = 'minutes';
    //
    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
}
