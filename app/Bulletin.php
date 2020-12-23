<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
	protected $table = 'bulletins';
    //
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
}
