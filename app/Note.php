<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    //
	protected $table = 'notes';
    //
    public function property(){
    	return $this->belongsTo(Property::class);
    }
    public function concept(){
    	return $this->belongsTo(Concept::class);
    }
    public function bill(){
    	return $this->belongsTo(Bill::class);
    }
}
