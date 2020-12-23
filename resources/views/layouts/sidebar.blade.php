<header class="main-header">
	
	<!-- sidebar -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->

    <a href="inicio" class="brand-link">
      <img src="/Views/img/plantilla/OPCION_2/AF_FAVICON-01.png" alt="Logotipo_Esforza" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Forzzeti</span>
    </a>
    <div class="sidebar">

    	<!-- sidebar-menu -->

		<nav class="mt-2">
        	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    	<!-- User panel -->

    		<li class="nav-item has-treeview" id="inicioTree">
            	<a href="inicio" class="nav-link" id="inicio">
              <?php 
                if(session('photo') != "" && session('photo') != null){
                  echo '<img src="'.session('photo').'" class="nav-icon" alt="User Image">';
                }else{
                  echo '<img src="/Views/img/usuarios/anonymous.png" class="nav-icon" alt="User Image">';
                }
               ?>
		         	
		            <p>
		              <?php echo session('name') ?>
		              <i class="right fa fa-angle-left"></i>
		            </p>
            	</a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link btnEditarMain" idUsuario="<?php echo session('id') ?>" tipoUsuario="{{session('rank')}}" data-toggle="modal" data-target="#modalEditarMain">
                  <i class="fa fa-key nav-icon"></i>
                  <p>Editar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/salir" class="nav-link">
                  <i class="fa fa-times-circle nav-icon"></i>
                  <p>Salir</p>
                </a>
              </li>
            </ul>
          </li>
          @if(session('rank')=='Admin')
          <li class="nav-item">
            <a href="parametros" class="nav-link" id="parametros">
              <i class="nav-icon fas fa-cogs"></i>
              <p>Parametros</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="unidades" class="nav-link" id="unidades">
              <i class="nav-icon fas fa-building"></i>
              <p>Unidades</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="propiedades" class="nav-link" id="propiedades">
              <i class="nav-icon fas fa-home"></i>
              <p>Bienes</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="propietarios" class="nav-link" id="propietarios">
              <i class="nav-icon fas fa-user"></i>
              <p>Propietarios</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="arrendatarios" class="nav-link" id="arrendatarios">
              <i class="nav-icon fas fa-user"></i>
              <p>Arrendatarios</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="encargados" class="nav-link" id="encargados">
              <i class="nav-icon fas fa-user"></i>
              <p>Encargados</p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="boletines" class="nav-link" id="boletines">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>Boletines</p>
            </a>
          </li>
          @if(session('rank')!='Arrendatario')
          <li class="nav-item">
            <a href="asambleas" class="nav-link" id="asambleas">
              <i class="nav-icon fas fa-handshake"></i>
              <p>Asambleas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pagos" class="nav-link" id="pagos">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>Pagos</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="facturas" class="nav-link" id="facturas">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>Facturas</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="documentos" class="nav-link" id="documentos">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Documentos</p>
            </a>
          </li>
          @endif
          @if(session('rank')=="Admin")
          <li class="nav-item">
            <a href="emails" class="nav-link" id="emails">
              <i class="nav-icon fas fa-envelope"></i>
              <p>Emails</p>
            </a>
          </li>
          @endif
          @if(session('rank')=="Admin")
          <li class="nav-item">
            <a href="reportes" class="nav-link" id="reportes">
              <i class="nav-icon fas fa-file-excel"></i>
              <p>Reportes</p>
            </a>
          </li>
          @endif
        </ul>
      </nav>

    </div>

   
  </aside>
	
</header>