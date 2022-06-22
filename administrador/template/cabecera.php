<?php
session_start();
if(!isset($_SESSION['usuario'] )){
  header("Location:../index.php");
}else{


if($_SESSION['usuario']=="ok"){
$nombreUsuario=$_SESSION["nombreUsuario"];

}

}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>

  <?php $url="http://".$_SERVER['HTTP_HOST']."/Sitio Web" ?>
      
<nav class="navbar navbar-expand navbar-light bg-light">
    <div class="nav navbar-nav">
        <a class="nav-item nav-link active" href="#">Administrador del Sitio Web <span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/inicio.php">Inicio</a>
        <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/Seccion/servicios.php">Servicios</a>
        <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/Seccion/empleados.php">Empleados</a>
        <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/Seccion/cerrar.php">Cerra Sesion</a>
        <a class="nav-item nav-link" href="<?php echo $url;?>">Vista del Sitio Web</a>
    </div>
</nav>

<div class="container">
<br/>
    <div class="row">