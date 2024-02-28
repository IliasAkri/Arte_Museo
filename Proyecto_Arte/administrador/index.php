<?php
session_start();
if ($_POST) {
    if (($_POST['usuario']=="administrador")&&($_POST['contrasenia']=="1234")) { /*mediante sentencias: esta es la linea que habria que cambiar por las de la bbdd de esta manera: 
        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE id=:id");
        $sentenciaSQL->bindParam(':id',$txtID);
        $sentenciaSQL->execute();
        $libro = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

        $txtNombre= $libro['nombre'];
        $txtImagen= $libro['imagen'];*/
        $_SESSION['usuario']="ok";
        $_SESSION['nombreUsuario']="Administrador";
        
        header('Location: inicio.php');
    }else{
        $mensaje="Error: El usuario o contraseñas son incorrectos";
    }



}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Administrador</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login.css" />
  </head>
  <body>
    <div>
        <a href="http://localhost/Proyecto_Arte/" class="atras">Ir Atrás</a>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                
            </div>
            <div class="col-md-4">
                <br><br><br>
                <div class="card">
                    <div class="card-header">
                        Login
                    </div>
                    <div class="card-body">

                    <?php  
                    if (isset($mensaje)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                    <?php } ?>
                        
                        <form method="POST">
                        <div class = "form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">                        
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Contraseña:</label>
                        <input type="password" class="form-control" name="contrasenia" placeholder="Escribe tu contraseña">
                    </div>
                    <button type="submit" class="btn btn-primary">Entrar como administrador</button>
                    </form>    
                    </div>
                </div>
            </div>
            
        </div>
    </div>
  </body>
</html>