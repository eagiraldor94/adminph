<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
	protected $table = 'packages';
    //
    public function property(){
    	return $this->belongsTo(Property::class);
    }
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
}
