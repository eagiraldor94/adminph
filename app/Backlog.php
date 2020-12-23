<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Backlog extends Model
{
	protected $table='backlogs';
    //
    public function property(){
    	return $this->belongsTo(Property::class);
    }
    public function payment(){
    	return $this->belongsTo(Payment::class);
    }
    public function concept(){
    	return $this->belongsTo(Concept::class);
    }
}
