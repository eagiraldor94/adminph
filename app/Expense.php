<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
	protected $table = 'expenses';
    //
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
}
