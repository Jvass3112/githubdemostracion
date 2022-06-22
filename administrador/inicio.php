<?php include('template/cabecera.php'); ?>

        <div class="col-md-12">
        <div class="jumbotron">
       <h1 class="display-3">Bienvenido <?php echo $nombreUsuario; ?></h1>
       <p class="lead">Vamos administrar todos los servicios </p>
       <hr class="my-2">
       <p>Comencemos</p>
       <p class="lead">
           <a class="btn btn-primary btn-lg" href="Seccion/servicios.php" role="button">Administrar Servicios</a>
       </p>
      </div> 
        </div>
        
        <?php include('template/pie.php'); ?>