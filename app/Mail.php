<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    //
    protected $table = 'mails';
    public function property(){
    	return $this->belongsTo(Property::class);
    }
}
