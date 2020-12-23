<?php

namespace adminph;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
	protected $table = 'organizations';
    //
    public function propertys(){

    	return $this->hasMany(Property::class);
    }
    //
    public function propietarys(){

    	return $this->hasMany(Propietary::class);
    }
    public function lessees(){

    	return $this->hasMany(Lessee::class);
    }
    public function attendants(){

    	return $this->hasMany(Attendant::class);
    }
    public function bulletins(){

    	return $this->hasMany(Bulletin::class);
    }
    public function assemblys(){

    	return $this->hasMany(Assembly::class);
    }
    public function bills(){

        return $this->hasMany(Bill::class);
    }
    public function payments(){

        return $this->hasMany(Payment::class);
    }
    public function guests(){
        return $this->hasMany(Guest::class);
    }
    public function packages(){
        return $this->hasMany(Package::class);
    }
    public function minutes(){
        return $this->hasMany(Minute::class);
    }
    public function reports(){
        return $this->hasMany(Report::class);
    }
    public function adds(){
        return $this->hasMany(Add::class);
    }
}
