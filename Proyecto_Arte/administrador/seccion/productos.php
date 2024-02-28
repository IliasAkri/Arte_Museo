<?php include("../template/cabecera.php");?>
<?php  

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";


/*Modificado*/ 
$txtTipo_Obra=(isset($_POST['txtTipo_Obra']))?$_POST['txtTipo_Obra']:"";
$txtPrecio_Estimado=(isset($_POST['txtPrecio_Estimado']))?$_POST['txtPrecio_Estimado']:"";
$txtAutor=(isset($_POST['txtAutor']))?$_POST['txtAutor']:"";


include("../config/bd.php");

switch ($accion) {
    case 'Agregar':
        $sentenciaSQL = $conexion->prepare("INSERT INTO ObrasArte (tipo_obra, nombre, precio_estimado, autor, imagen) VALUES (:tipo_obra,:nombre,:precio_estimado,:autor,:imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':tipo_obra',$txtTipo_Obra);
        $sentenciaSQL->bindParam(':precio_estimado',$txtPrecio_Estimado);
        $sentenciaSQL->bindParam(':autor',$txtAutor);
        
        $fecha = new DateTime();
        //Para que en el caso de que suban varios archivos con el mismo nombre no haya conflicto
        $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:["imagen.jpg"];

        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if ($tmpImagen!="") {
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
        }
        $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
        $sentenciaSQL->execute();

        header("Location:productos.php");
        break;
    
    case 'Modificar':
        $sentenciaSQL = $conexion->prepare("UPDATE ObrasArte SET nombre=:nombre, tipo_obra=:tipo_obra, precio_estimado=:precio_estimado, autor=:autor WHERE ID=:ID");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        $sentenciaSQL->bindParam(':tipo_obra',$txtTipo_Obra);
        $sentenciaSQL->bindParam(':precio_estimado',$txtPrecio_Estimado);
        $sentenciaSQL->bindParam(':autor',$txtAutor);
        $sentenciaSQL->bindParam(':ID',$txtID);
        $sentenciaSQL->execute();

        if ($txtImagen!="") {
            $fecha = new DateTime();
            $nombreArchivo = ($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:["imagen.jpg"];
            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM ObrasArte WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID',$txtID);
        $sentenciaSQL->execute();
        $obra = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($obra["imagen"]) && ($obra["imagen"]!="imagen.jpg") ) {
            if (file_exists("../../img/".$obra["imagen"])) {
                unlink("../../img/".$obra["imagen"]);
            }
        }
            $sentenciaSQL = $conexion->prepare("UPDATE ObrasArte SET imagen=:imagen WHERE ID=:ID");
            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
        }
        header("Location:productos.php");
        break;
    case 'Cancelar':
        header("Location:productos.php");
        break;

    case 'Seleccionar':
        $sentenciaSQL = $conexion->prepare("SELECT * FROM ObrasArte WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID',$txtID);
        $sentenciaSQL->execute();
        $obra = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre= $obra['nombre'];
        $txtTipo_Obra= $obra['tipo_obra'];
        $txtPrecio_Estimado= $obra['precio_estimado'];
        $txtAutor= $obra['autor'];
        $txtImagen= $obra['imagen'];
        //echo "Presionando boton Seleccionar";
        break;    

    case 'Borrar':

        $sentenciaSQL = $conexion->prepare("SELECT * FROM ObrasArte WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID',$txtID);
        $sentenciaSQL->execute();
        $obra = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        if (isset($obra["imagen"]) && ($obra["imagen"]!="imagen.jpg") ) {
            if (file_exists("../../img/".$obra["imagen"])) {
                unlink("../../img/".$obra["imagen"]);
            }
        }

        $sentenciaSQL = $conexion->prepare("DELETE FROM ObrasArte WHERE ID=:ID");
        $sentenciaSQL->bindParam(':ID',$txtID);
        $sentenciaSQL->execute();
        header("Location:productos.php");

        break;
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM ObrasArte");
$sentenciaSQL->execute();
$listaObrasArte = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);



?>
<div class="col-md-5" id="crear_obras">
    <div class="card">
        <div class="card-header">
            Datos de Obras
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class = "form-group">
                    <label for="txtID">ID:</label>
                    <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" id="txtID" name="txtID" placeholder="ID">
                </div>
                
                <div class = "form-group">
                    <label for="txtNombre">Nombre:</label>
                    <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" id="txtNombre" name="txtNombre" placeholder="Nombre">
                </div>
                
                <div class = "form-group">
                    <!-- Introduccion del tipo de obra, precio_estimado y autor al formulario del administrador -->
                    <div class = "form-group">
                        <label for="txtTipo_Obra">Tipo de Obra:</label>
                        <select required class="form-control" value="<?php echo $txtTipo_Obra; ?>" id="txtTipo_Obra" name="txtTipo_Obra">
                            <option value="Cuadro">Cuadro</option>
                            <option value="Escultura">Escultura</option>
                        </select>
                        <!--<input type="text" required class="form-control" value="<?php echo $txtTipo_Obra; ?>" id="txtTipo_Obra" name="txtTipo_Obra" placeholder="Introduce el tipo de obra">-->
                    </div>
                    
                    <div class = "form-group">
                        <label for="txtPrecio_Estimado">Precio estimado:</label>
                        <input type="text" required class="form-control" value="<?php echo $txtPrecio_Estimado; ?>" id="txtPrecio_Estimado" name="txtPrecio_Estimado" placeholder="Introduce el precio de la obra">
                    </div>
                        

                    <div class = "form-group">
                        <label for="txtAutor">Autor:</label>
                        <input type="text" required class="form-control" value="<?php echo $txtAutor; ?>" id="txtAutor" name="txtAutor" placeholder="Nombre del autor:">
                    </div>
                    
                    <div class = "form-group">
                        <label for="txtNombre">Imagen:</label>
                        <br/>
                        <?php 
                    if ($txtImagen!="") { ?>
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen;?>" width="150" alt="" srcset=""/>
                    <?php } ?>
                    <input type="file" class="form-control" id="txtImagen" name="txtImagen" placeholder="ID">
                </div>
                    
                <div class="btn-group" role="group" aria-label="">
                    <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                    <button type="submit" name="accion" <?php echo ($accion!="Seleccionar")?"disabled":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-12" id="tabla_obras">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Autor</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaObrasArte as $libro) {?>
                <tr>
                    <td><?php echo $libro['ID']; ?></td>
                    <td><?php echo $libro['nombre']; ?></td>
                    <td><?php echo $libro['autor']; ?></td>
                    <td>
                        <img src="../../img/<?php echo $libro['imagen']; ?>" class="img-thumbnail rounded" width="50" alt="imagen obra">
                    </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['ID']; ?>"/>
                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />
                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger" />
                        </form>
                    </td>
                </tr>
            <?php }?>
        </tbody>
    </table>
</div>
    
<?php include("../template/pie.php");?>