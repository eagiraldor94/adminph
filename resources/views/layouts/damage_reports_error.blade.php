@extends('base_layout')
@section('title')
	Error
@stop
@section('content')
<script>
	swal({
		type: "error",
		title: "¡Está utilizando caracteres no permitidos, o su archivo no se encuentra en formato jpeg, png o pdf!",
		showConfirmButton: true,
		confirmButtonText: "Cerrar",
		closeOnConfirm: false
		}).then((result)=>{
				if(result.value){
					window.location = "reportes-danos";
			}
		});
</script>
@stop