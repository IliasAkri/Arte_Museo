<?php include("template/cabecera.php"); ?>

<?php 
include("administrador/config/bd.php");


$sentenciaSQL = $conexion->prepare("SELECT * FROM ObrasArte");
$sentenciaSQL->execute();
$listaObras = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaObras as $obras){ ?>
<div class="col-md-3">
<div class="card">
    <img class="card-img-top" src="./img/<?php echo $obras['imagen']; ?>" alt="imagen obras">
    <div class="card-body">
        <h3 class="card-title"><?php echo $obras['nombre']; ?></h3>
        <h6 class="card-title"><?php echo $obras['autor']; ?></h6>
        <h6 class="card-title"><?php echo $obras['precio_estimado']; ?></h6>
        <a name="" id="" class="btn btn-primary" href="" role="button">Ver más</a>
    </div>
</div>
</div>

<?php } ?>


<?php include("template/pie.php"); ?>