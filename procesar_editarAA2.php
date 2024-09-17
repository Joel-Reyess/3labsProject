<?php
include('connection.php');

$ItemID = $_POST['txtItemID'];
$nombre = $_POST['txtNombre'];
$Descripcion = $_POST['txtDescripcion'];
$Stock = $_POST['txtStock'];


$resultado = mysqli_query($conn, "UPDATE `materiales` SET `Nombre` = '$nombre', `Descripcion` = '$Descripcion', `Stock` = '$Stock'
WHERE `ItemID` = '$ItemID'") or die("error");

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: MaterialesA2.php?status=success");
exit();
?>
