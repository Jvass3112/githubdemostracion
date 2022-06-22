
<?php include("../template/cabecera.php");?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST ['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST ['txtNombre']:"";
$txtCargo=(isset($_POST['txtCargo']))?$_POST ['txtCargo']:"";
$txtHorario=(isset($_POST['txtHorario']))?$_POST ['txtHorario']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/db.php");

switch($accion){


Case "Agregar":
$sentenciaSQL=$conexion->prepare("INSERT INTO empleados (nombre, cargo,horario, imagen) VALUES (:nombre, :cargo, :horario, :imagen);");
$sentenciaSQL->bindparam(':nombre',$txtNombre);
$sentenciaSQL->bindparam(':cargo',$txtCargo);
$sentenciaSQL->bindparam(':horario',$txtHorario);
$fecha= new DateTime();
$nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

$tmpImagen=$_FILES["txtImagen"]["tmp_name"];

if($tmpImagen!=""){


       move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

}

$sentenciaSQL->bindparam(':imagen',$txtImagen);
$sentenciaSQL->execute();

header("Location:empleados.php");
break;

Case "Modificar":

    $sentenciaSQL=$conexion->prepare("UPDATE empleados SET nombre=:nombre, cargo=:cargo, horario=:horario WHERE id=:id");
    $sentenciaSQL->bindparam(':nombre',$txtNombre);
    $sentenciaSQL->bindparam(':cargo',$txtCargo);
    $sentenciaSQL->bindparam(':horario',$txtHorario);
    $sentenciaSQL->bindparam(':id',$txtID);
    $sentenciaSQL->execute();

    if($txtImagen!=""){

        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        

        $sentenciaSQL=$conexion->prepare("SELECT imagen FROM empleados WHERE id=:id");
        $sentenciaSQL->bindparam(':id',$txtID);
        $sentenciaSQL->execute();
        $listaservicios=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        
        if(isset($listaservicios["imagen"]) &&($listaservicios["imagen"]!="imagen.jpg") ){
        
            if(file_exists("../../img/".$listaservicios["imagen"])){
        
        unlink("../../img/".$listaservicios["imagen"]);
        
        }
        
        }


    $sentenciaSQL=$conexion->prepare("UPDATE empleados SET imagen=:imagen WHERE id=:id");
    $sentenciaSQL->bindparam(':imagen',$nombreArchivo);
    $sentenciaSQL->bindparam(':id',$txtID);
    $sentenciaSQL->execute();

    }
header("Location:empleados.php");
break;

Case "Cancelar":

header("Location:empleados.php");

break;

Case "Seleccionar":


$sentenciaSQL=$conexion->prepare("SELECT * FROM empleados WHERE id=:id");
$sentenciaSQL->bindparam(':id',$txtID);
$sentenciaSQL->execute();
$listaservicios=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

$txtNombre=$listaservicios ['nombre'];
$txtDescripcion=$listaservicios ['cargo'];
$txtPrecio=$listaservicios ['horario'];
$txtImagen=$listaservicios ['imagen'];

//echo "Presionado boton Seleccionar";
break;

Case "Borrar":


$sentenciaSQL=$conexion->prepare("SELECT imagen FROM empleados WHERE id=:id");
$sentenciaSQL->bindparam(':id',$txtID);
$sentenciaSQL->execute();
$listaservicios=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

if(isset($listaservicios["imagen"]) &&($listaservicios["imagen"]!="imagen.jpg") ){

    if(file_exists("../../img/".$listaservicios["imagen"])){

unlink("../../img/".$listaservicios["imagen"]);

}

}

$sentenciaSQL=$conexion->prepare("DELETE FROM empleados where id=:id");
$sentenciaSQL->bindparam(':id',$txtID);
$sentenciaSQL->execute();
header("Location:empleados.php");
break;

}

$sentenciaSQL=$conexion->prepare("SELECT * FROM empleados");
$sentenciaSQL->execute();
$listaservicios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="col-md-5">
    
<div class="card">
    <div class="card-header">
        Datos del nuevo servicio
    </div>

    <div class="card-body">
      
    <form method="POST" enctype="multipart/form-data">

<div class = "form-group">
<label for="txtID">ID:</label>
<input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID">
</div>

<div class = "form-group">
<label for="txtNombre">Nombre:</label>
<input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del empleado">
</div>

<div class = "form-group">
<label for="txtNombre">Cargo:</label>
<input type="text" required class="form-control" value="<?php echo $txtCargo; ?>" name="txtCargo" id="txtCargo" placeholder="Cargo o puesto del empleado">
</div>

<div class = "form-group">
<label for="txtNombre">Horario:</label>
<input type="text" required class="form-control" value="<?php echo $txtHorario ?>" name="txtHorario" id="txtHorario" placeholder="Horario del empleado">
</div>

<div class = "form-group">
<label for="txtNombre">Imagen:</label>

<br/>

<?php 
if($txtImagen!=""){

?>

<?php } ?>

<img class="img-thumbnail rounded"  src="../../img/<?php echo $txtImagen; ?>" width="50" alt="" srcset=""> 

<input type="file"  class="form-control" name="txtImagen" id="txtImagen" placeholder="Nombre del Servicio">
</div>

<div class="btn-group" role="group" aria-label="">
    <button type="submit" name="accion"  <?php echo ($accion=="Seleccionar")?"disabled":""; ?>  value="Agregar" class="btn btn-success">Agregar</button>
    <button type="submit" name="accion"  <?php echo ($accion!=="Seleccionar")?"disabled":""; ?>  value="Modificar" class="btn btn-warning">Modificar</button>
    <button type="submit" name="accion"  <?php echo ($accion!=="Seleccionar")?"disabled":""; ?>  value="Cancelar" class="btn btn-info">Cancelar</button>
</div>

</form>



    </div>

  

</div>




</div>

<div class="col-md-7">
  
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Cargo</th>
            <th>Horario</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listaservicios as $servicios) {?>
        <tr>
            <td><?php echo $servicios['id']; ?></td>
            <td><?php echo $servicios['nombre']; ?></td>
            <td><?php echo $servicios['cargo']; ?></td>
            <td><?php echo $servicios['horario']; ?></td>

            <td>

            <img class="img-thumbnail rounded" src="../../img/<?php echo $servicios['imagen']; ?>" width="50" alt="" srcset="">    

            
        
        </td>

            <td>
                <form method="post">

                <input type="hidden" name="txtID" id="txtID" value="<?php echo $servicios['id']; ?>"/>

                <input type="submit"name= "accion" value="Seleccionar" class="btn btn-primary"/>
                
                <input type="submit"name= "accion" value="Borrar" class="btn btn-danger"/>

                     


                </form>
            
            </td>


        </tr>
     <?php } ?>

    </tbody>
</table>

</div>

<?php include("../template/pie.php");?>