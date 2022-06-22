
<?php include("../template/cabecera.php");?>
<?php
$txtID=(isset($_POST['txtID']))?$_POST ['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST ['txtNombre']:"";
$txtDescripcion=(isset($_POST['txtDescripcion']))?$_POST ['txtDescripcion']:"";
$txtPrecio=(isset($_POST['txtPrecio']))?$_POST ['txtPrecio']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/db.php");

switch($accion){


Case "Agregar":
$sentenciaSQL=$conexion->prepare("INSERT INTO serviciossalon (nombre, descripcion,precio, imagen) VALUES (:nombre, :descripcion, :precio, :imagen);");
$sentenciaSQL->bindparam(':nombre',$txtNombre);
$sentenciaSQL->bindparam(':descripcion',$txtDescripcion);
$sentenciaSQL->bindparam(':precio',$txtPrecio);
$fecha= new DateTime();
$nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

$tmpImagen=$_FILES["txtImagen"]["tmp_name"];

if($tmpImagen!=""){


       move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

}

$sentenciaSQL->bindparam(':imagen',$txtImagen);
$sentenciaSQL->execute();

header("Location:servicios.php");
break;

Case "Modificar":

    $sentenciaSQL=$conexion->prepare("UPDATE serviciossalon SET nombre=:nombre, descripcion=:descripcion, precio=:precio WHERE id=:id");
    $sentenciaSQL->bindparam(':nombre',$txtNombre);
    $sentenciaSQL->bindparam(':descripcion',$txtDescripcion);
    $sentenciaSQL->bindparam(':precio',$txtPrecio);
    $sentenciaSQL->bindparam(':id',$txtID);
    $sentenciaSQL->execute();

    if($txtImagen!=""){

        $fecha= new DateTime();
        $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        

        $sentenciaSQL=$conexion->prepare("SELECT imagen FROM serviciossalon WHERE id=:id");
        $sentenciaSQL->bindparam(':id',$txtID);
        $sentenciaSQL->execute();
        $listaservicios=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
        
        if(isset($listaservicios["imagen"]) &&($listaservicios["imagen"]!="imagen.jpg") ){
        
            if(file_exists("../../img/".$listaservicios["imagen"])){
        
        unlink("../../img/".$listaservicios["imagen"]);
        
        }
        
        }


    $sentenciaSQL=$conexion->prepare("UPDATE serviciossalon SET imagen=:imagen WHERE id=:id");
    $sentenciaSQL->bindparam(':imagen',$nombreArchivo);
    $sentenciaSQL->bindparam(':id',$txtID);
    $sentenciaSQL->execute();

    }
header("Location:servicios.php");
break;

Case "Cancelar":

header("Location:servicios.php");

break;

Case "Seleccionar":


$sentenciaSQL=$conexion->prepare("SELECT * FROM serviciossalon WHERE id=:id");
$sentenciaSQL->bindparam(':id',$txtID);
$sentenciaSQL->execute();
$listaservicios=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

$txtNombre=$listaservicios ['nombre'];
$txtDescripcion=$listaservicios ['descripcion'];
$txtPrecio=$listaservicios ['precio'];
$txtImagen=$listaservicios ['imagen'];

//echo "Presionado boton Seleccionar";
break;

Case "Borrar":


$sentenciaSQL=$conexion->prepare("SELECT imagen FROM serviciossalon WHERE id=:id");
$sentenciaSQL->bindparam(':id',$txtID);
$sentenciaSQL->execute();
$listaservicios=$sentenciaSQL->fetch(PDO::FETCH_LAZY);

if(isset($listaservicios["imagen"]) &&($listaservicios["imagen"]!="imagen.jpg") ){

    if(file_exists("../../img/".$listaservicios["imagen"])){

unlink("../../img/".$listaservicios["imagen"]);

}

}

$sentenciaSQL=$conexion->prepare("DELETE FROM serviciossalon where id=:id");
$sentenciaSQL->bindparam(':id',$txtID);
$sentenciaSQL->execute();
header("Location:servicios.php");
break;

}

$sentenciaSQL=$conexion->prepare("SELECT * FROM serviciossalon");
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
<input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del Servicio">
</div>

<div class = "form-group">
<label for="txtNombre">Descripcion:</label>
<input type="text" required class="form-control" value="<?php echo $txtDescripcion; ?>" name="txtDescripcion" id="txtDescripcion" placeholder="Descripcion del Servicio">
</div>

<div class = "form-group">
<label for="txtNombre">Precio:</label>
<input type="text" required class="form-control" value="<?php echo $txtPrecio ?>" name="txtPrecio" id="txtPrecio" placeholder="Precio del Servicio">
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
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($listaservicios as $servicios) {?>
        <tr>
            <td><?php echo $servicios['id']; ?></td>
            <td><?php echo $servicios['nombre']; ?></td>
            <td><?php echo $servicios['descripcion']; ?></td>
            <td><?php echo $servicios['precio']; ?></td>

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