<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
	protected $table = 'reports';
    //
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
    public function property(){
    	return $this->belongsTo(Property::class);
    }
}
