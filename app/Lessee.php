<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Lessee extends Model
{
	protected $table = 'lessees';
    //
    
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
    public function property(){
    	return $this->belongsTo(Property::class);
    }
}
