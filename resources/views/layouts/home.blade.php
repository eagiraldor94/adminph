@extends('base_layout')
@if(session('rank')!= null && session('rank') != "")
	@section('title')
		Home
	@stop
@else
	@section('title')
		Login
	@stop
@endif
@section('js')
  <!-- Personalizado -->
  <script src="Views/js/home.js"></script>
@stop
@if(session('rank')!= null && session('rank') != "")
	{{-- @section('content')
		@if(session('rank')=="Admin")
			@include('layouts.admin_view')
		@else
			@include('layouts.user_view')
		@endif
	@stop --}}
@else
	@section('content')
		@include('layouts.login')
	@stop
@endif