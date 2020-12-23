<?php

namespace adminph\Http\Controllers;

use Illuminate\Http\Request;

class ControladorReservas extends Controller
{
	public function index(){
	  return view('booking/list', ['events' => Event::orderBy('start_time')->get()]);
	}
	public function create(){
	  return view('booking/create');
	}
	public function edit($id){
	  return view('booking/edit', ['event' => Event::findOrFail($id)]);
	}
	public function destroy($id){
	  $event = Event::find($id);
	  $event->delete();
	  
	  return redirect('events');
	}
}
