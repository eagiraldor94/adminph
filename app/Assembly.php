<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Assembly extends Model
{
	protected $table = 'assemblys';
    //
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
}
