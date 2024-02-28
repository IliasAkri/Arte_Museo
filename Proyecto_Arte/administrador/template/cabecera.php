<?php  
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location:../index.php");
}else{
  if ($_SESSION['usuario']=="ok") {
    $nombreUsuario = $_SESSION["nombreUsuario"];
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
    <link rel="stylesheet" href="../../css/main.css" />
    <link rel="stylesheet" href=".././css/main.css" />
    <link rel="stylesheet" href="../../css/productos.css" />
    <link rel="stylesheet" href=".././css/productos.css" />
  </head>
<body>

  <?php $url="http://".$_SERVER['HTTP_HOST']."/Proyecto_Arte" ?>
    <nav class="navbar navbar-expand-lg">
        <ul class="nav navbar-nav">
            <li class="nav-item">
              <img width="50" src="../img/Logo_1_reverse.svg" alt="LOGO">
            </li>
            <li class="nav-item">
              <a href="#">Administrador del sitio web <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a href="<?php echo $url;?>/administrador/inicio.php">Inicio</a>
            </li> 
            <li class="nav-item">
              <a href="<?php echo $url;?>/administrador/seccion/productos.php">Obras</a>
            </li> 
            <li class="nav-item">
              <a href="<?php echo $url;?>/administrador/seccion/cerrar.php">Cerrar Sesión</a>
            </li> 
            <li class="nav-item">
              <a href="<?php echo $url;?>">Ver sitio web</a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <br>

