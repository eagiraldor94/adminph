<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Add extends Model
{
	protected $table = 'adds';
    //
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
    public function property(){
    	return $this->belongsTo(Property::class);
    }
}
