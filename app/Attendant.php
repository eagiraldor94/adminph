<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Attendant extends Model
{
	protected $table = 'attendants';
    //
    
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
    public function property(){
    	return $this->belongsTo(Property::class);
    }
}
