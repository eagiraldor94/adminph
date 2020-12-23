<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Propietary extends Model
{
	protected $table = 'propietarys';
    //
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
    public function property(){
    	return $this->belongsTo(Property::class);
    }
    
}
