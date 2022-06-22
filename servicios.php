<?php include("template/Cabecera.php"); ?>

<?php
include("administrador/config/db.php");
$sentenciaSQL=$conexion->prepare("SELECT * FROM serviciossalon");
$sentenciaSQL->execute();
$listaservicios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaservicios as $servicio) { ?>

<div class="col-md-3">
<div class="card">

<img class="card-img-top" src="./img/<?php echo $servicio['imagen']; ?>" alt="">

<div class="card-body">

    <h4 class="card-title"><?php echo $servicio['nombre']; ?> </h4>
    </br> </br>
    <h4 class="card-title"><?php echo $servicio['descripcion']; ?> </h4>
    <p class="block-38-subheading"> <?php echo $servicio['precio']; ?> </p>
    <a name="" id="" class="btn btn-primary" href="#" role="button"> Agendar cita </a>
</div>
</div>
</div>

<?php } ?>





<?php include("template/Pie.php"); ?>