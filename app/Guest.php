<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
	protected $table = 'guests';
    //
    public function property(){
    	return $this->belongsTo(Property::class);
    }
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
}
