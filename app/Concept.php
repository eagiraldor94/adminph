<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Concept extends Model
{
	protected $table = 'concepts';
    //
    public function documents(){
        return $this->hasMany(Document::class);
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function backlogs(){
    	return $this->hasMany(Backlog::class);
    }
}
