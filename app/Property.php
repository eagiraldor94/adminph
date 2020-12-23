<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
	protected $table = 'propertys';
    //
    public function organization(){
    	return $this->belongsTo(Organization::class);
    }
    public function propietary(){
    	return $this->hasOne(Propietary::class);
    }
    public function lessee(){
    	return $this->hasOne(Lessee::class);
    }
    public function attendant(){
        return $this->hasOne(Attendant::class);
    }
    public function payments(){
        return $this->hasMany(Payment::class);
    }
    public function backlogs(){
        return $this->hasMany(Backlog::class);
    }
    public function bills(){
        return $this->hasMany(Bill::class);
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function documents(){
        return $this->hasMany(Document::class);
    }
    public function mails(){
        return $this->hasMany(Mail::class);
    }
    public function guests(){
        return $this->hasMany(Guest::class);
    }
    public function packages(){
        return $this->hasMany(Package::class);
    }
    public function reports(){
        return $this->hasMany(Report::class);
    }
    public function adds(){
        return $this->hasMany(Add::class);
    }
}
