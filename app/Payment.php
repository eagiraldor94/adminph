<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $table = 'payments';
    //
    public function property(){
    	return $this->belongsTo(Property::class);
    }
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
    public function backlogs(){
        return $this->hasMany(Backlog::class);
    }
}
