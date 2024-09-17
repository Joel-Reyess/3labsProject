<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connection.php');

$ns = $_POST['txtNS'];
$nombre = $_POST['txtNombre'];
$Descripcion = $_POST['txtDescripcion'];
$Stock = $_POST['txtStock'];
$Edificio = $_POST['txtEdificio'];

$consulta = "INSERT INTO `herramientas` (`NS`,`Nombre`, `Descripcion`, `Stock`, `EdificioID`) VALUES ('$ns','$nombre', '$Descripcion', '$Stock', '$Edificio')";

$resultado = mysqli_query($conn, $consulta) or die("Error de registro: " . mysqli_error($conn));

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: IndexA1.php?status=success");
exit();
?>
