@extends('base_layout')
@section('title')
  Prueba
@stop
@section('css')
    <link href='/Views/plugins/fullcalendar-4.3.1/packages/core/main.min.css' rel='stylesheet' />
    <link href='/Views/plugins/fullcalendar-4.3.1/packages/daygrid/main.min.css' rel='stylesheet' />
    <link href='/Views/plugins/fullcalendar-4.3.1/packages/timegrid/main.min.css' rel='stylesheet' />
@section('js') 
    <script src='/Views/plugins/fullcalendar-4.3.1/packages/core/main.min.js'></script>
    <script src='/Views/plugins/fullcalendar-4.3.1/packages/core/locales/es.js'></script>
    <script src='/Views/plugins/fullcalendar-4.3.1/packages/daygrid/main.min.js'></script>
    <script src='/Views/plugins/fullcalendar-4.3.1/packages/timegrid/main.min.js'></script>
    <script src='/Views/plugins/fullcalendar-4.3.1/packages/interaction/main.min.js'></script>
    <script src='/Views/plugins/fullcalendar-4.3.1/packages/bootstrap/main.min.js'></script>
    <script>

          document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
              plugins: ['dayGrid','timeGrid','interaction','bootstrap'],
              header: {
                center: 'dayGridMonth,timeGridWeek,timeGridDay' // buttons for switching between views
              },
              events: [
                {
                  title: 'Event1',
                  start: '2019-11-25'
                }
                // etc...
              ],
              defaultView: ['dayGridMonth'],
              selectable: 'true',
              editable: 'true',
              dateClick: function(info) {
                jQuery.noConflict(); 
                jQuery('#modalEditarMain').modal('show'); 
              },
              eventClick: function(info) {
                jQuery.noConflict(); 
                jQuery('#modalEditarMain').modal('show'); 
              },
              locale: 'es'
            });

            calendar.render();
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
              <h1>Seleccione el reporte
                <small>y la fecha</small></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
                <li class="breadcrumb-item active">Reportes</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      <section class="content">
<!-- Default box -->
      <div class="card mb-5 pb-5 text-center">
        <div class="card-body">
            <div id="calendar" class='mx-3'></div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@stop
@include('layouts.edit_me')