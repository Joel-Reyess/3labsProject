<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connection.php');

$nombre = $_POST['txtNombre'];
$Descripcion = $_POST['txtDescripcion'];
$Stock = $_POST['txtStock'];
$Edificio = $_POST['txtEdificio'];

$consulta = "INSERT INTO `materiales` (`Nombre`, `Descripcion`, `Stock`, `EdificioID`) VALUES ('$nombre', '$Descripcion', '$Stock', '$Edificio')";

$resultado = mysqli_query($conn, $consulta) or die("Error de registro: " . mysqli_error($conn));

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: Materiales.php?status=success");
exit();
?>
