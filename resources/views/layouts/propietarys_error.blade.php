@extends('base_layout')
@section('title')
	Error
@stop
@section('content')
<script>
	swal({
		type: "error",
		title: "¡El ni usuario ni el nombre pueden ir vacíos o llevar caracteres especiales. El usuario debe llevar solo alfabeto basico, números y espacios!",
		showConfirmButton: true,
		confirmButtonText: "Cerrar",
		closeOnConfirm: false
		}).then((result)=>{
				if(result.value){
					window.location = "propietarios";
			}
		});
</script>
@stop