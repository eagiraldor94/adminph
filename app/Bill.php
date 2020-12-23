<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
	protected $table = 'bills';
    //
    public function property(){
    	return $this->belongsTo(Property::class);
    }
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }
}
