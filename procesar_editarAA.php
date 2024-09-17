<?php
include('connection.php');

$ItemID = $_POST['txtItemID'];
$nombre = $_POST['txtNombre'];
$Descripcion = $_POST['txtDescripcion'];
$Stock = $_POST['txtStock'];
$Edificio = $_POST['txtEdificio'];

$resultado = mysqli_query($conn, "UPDATE `materiales` SET `Nombre` = '$nombre', `Descripcion` = '$Descripcion', `Stock` = '$Stock', `EdificioID` = $Edificio
WHERE `ItemID` = '$ItemID'") or die("error");

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: Materiales.php?status=success");
exit();
?>
