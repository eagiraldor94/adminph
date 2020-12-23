@extends('base_layout')
@section('title')
	Home
@stop
@section('js')
  <!-- ChartJS -->
  <script src="/Views/plugins/chart.js/Chart.min.js"></script>
  <script src="/Views/js/vista-admin.js"></script>
  <script>
    $(function() {

    // Get context with jQuery - using jQuery's .get() method.
    var barChartCanvas = $('#barChart').get(0).getContext('2d')

    var barChartData = {
      labels  : [@for ($i = 0; $i < count($barMonths)-1; $i++) '{{$barMonths[$i]}}', @endfor '{{$barMonths[count($barMonths)-1]}}'],
      datasets: [
        {
          label               : 'Facturado',
          backgroundColor     : 'rgba(60,141,188,0.7)',
          borderColor         : 'rgba(60,141,188,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [@for ($i = 0; $i < count($barBills)-1; $i++) '{{$barBills[$i]}}', @endfor '{{$barBills[count($barBills)-1]}}']
        },
        {
          label               : 'Pagado',
          backgroundColor     : 'rgba(210, 214, 222, 0,9)',
          borderColor         : 'rgba(210, 214, 222, 0.8)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [@for ($i = 0; $i < count($barPays)-1; $i++) '{{$barPays[$i]}}', @endfor '{{$barPays[count($barPays)-1]}}']
        },
        {
          label               : 'Usado',
          backgroundColor     : 'brown',
          borderColor         : 'brown',
          pointRadius         : false,
          pointColor          : 'brown',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [@for ($i = 0; $i < count($barExpenses)-1; $i++) '{{$barExpenses[$i]}}', @endfor '{{$barExpenses[count($barExpenses)-1]}}']
        }
      ]
    }

    var barChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      datasetFill : false
    }

    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, { 
      type: 'bar',
      data: barChartData, 
      options: barChartOptions
    })

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: [
          'Facturado', 
          'Pagado',
          'Gastado', 
      ],
      datasets: [
        {
          data: [{{$billed}},{{$paid}},{{$used}}],
          backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
        }
      ]
    }
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions      
    })
    });//--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : [@for ($i = 0; $i < count($areaMonths)-1; $i++) '{{$areaMonths[$i]}}', @endfor '{{$areaMonths[count($areaMonths)-1]}}'],
      datasets: [
        {
          label               : 'Facturado',
          backgroundColor     : 'rgba(60,141,188,0.7)',
          borderColor         : 'rgba(60,141,188,0.6)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [@for ($i = 0; $i < count($areaBills)-1; $i++) '{{$areaBills[$i]}}', @endfor '{{$areaBills[count($areaBills)-1]}}']
        },
        {
          label               : 'Pagado',
          backgroundColor     : 'rgba(210, 214, 222, 0,9)',
          borderColor         : 'rgba(210, 214, 222, 0.8)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [@for ($i = 0; $i < count($areaPays)-1; $i++) '{{$areaPays[$i]}}', @endfor '{{$areaPays[count($areaPays)-1]}}']
        },
        {
          label               : 'Usado',
          backgroundColor     : 'brown',
          borderColor         : 'brown',
          pointRadius         : false,
          pointColor          : 'brown',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [@for ($i = 0; $i < count($areaExpenses)-1; $i++) '{{$areaExpenses[$i]}}', @endfor '{{$areaExpenses[count($areaExpenses)-1]}}']
        }
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

  </script>
@stop
@section('content')
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
            <div class="col-lg-2 my-auto text-center">
                @if(session('photo') != "" && session('photo') != null)
                    <img src="{{session('photo')}}" class="img-fluid img-circle" alt="User Image">
                @else
                    <img src="Views/img/usuarios/anonymous.png" class="img-fluid img-circle" alt="User Image">
                @endif
            </div>
            <div class="col-lg-5 my-auto">
              <h4>Bienvenido al Sistema de administración para Copropietarios de Forzzeti señor@ {{session('name')}}</h4>
              <h5>Elija el rango de fecha:</h5>
              <div class="input-group">
                <button type="button" class="btn btn-default" id="daterange-btn2">
                  <span id="reportrange2"><i class="fa fa-calendar"></i> Rango de fecha</span>
                  <i class="fa fa-caret-down"></i>
                </button>

              </div>
            </div>
            <div class="col-lg-5 my-auto">
            <!-- /.info-box -->
              <div class="info-box mb-3 bg-warning">
                <span class="info-box-icon"><i class="fas fa-file-invoice-dollar"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Facturado</span>
                  <span class="info-box-number">$ {{number_format($billed,2)}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            <!-- /.info-box -->
              <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="fas fa-dollar-sign"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Recaudado</span>
                  <span class="info-box-number">$ {{number_format($paid,2)}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            <!-- /.info-box -->
              <div class="info-box mb-3 bg-danger">
                <span class="info-box-icon"><i class="fas fa-hand-holding-usd"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Gastado</span>
                  <span class="info-box-number">$ {{number_format($used,2)}}</span>
                </div>
                <!-- /.info-box-content -->
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">

      <div class="row m-3">
      <!-- Small boxes (Stat box) -->
      <div class="col-12">
        <!-- BAR CHART -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Historico periodo seleccionado</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="barChart" style="height:230px; min-height:230px"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
            <!-- /.card -->
      </div>
      <!-- ./col -->
      <div class="col-6 col-xs-12">
        <!-- PIE CHART -->
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title">Ultimo mes</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <canvas id="pieChart" style="height:230px; min-height:230px"></canvas>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- ./col -->
      <div class="col-6 col-xs-12">
        <!-- AREA CHART -->
        <div class="card card-secondary">
          <div class="card-header">
            <h3 class="card-title">Ultimo año</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="areaChart" style="height:250px; min-height:250px"></canvas>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      </div>

      </section>
      <!-- /.content -->
    <!-- /.content-wrapper -->
@stop