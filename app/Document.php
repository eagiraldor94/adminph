<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
	protected $table='documents';
    //
    public function property(){
    	return $this->belongsTo(Property::class);
    }
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
    public function concept(){
    	return $this->belongsTo(Concept::class);
    }
}
