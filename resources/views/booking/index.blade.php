@extends('base_layout')
@section('title')
	Index
@stop
@section('js')
<script type="text/javascript">
   $(document).ready(function() {
      
     var base_url = '{{ url('/') }}';
     
       $('#calendar').fullCalendar({
         weekends: true,
         header: {
         left: 'prev,next today',
         center: 'title',
         right: 'month,agendaWeek,agendaDay'
         },
         editable: false,
         eventLimit: true, // allow "more" link when too many events
         events: {
         url: base_url + '/api',
         error: function() {
         alert("cannot load json");
         }
       }
     });
   });
</script>
@stop
@section('content')
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Calendario de reserva
                <small>/ Zonas comunes</small></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                <li class="breadcrumb-item active">Zonas comunes</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <section class="content">
        <div id="calendar"></div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@stop