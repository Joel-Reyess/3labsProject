<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connection.php');

$nombre = $_POST['txtNombre'];
$Descripcion = $_POST['txtDescripcion'];
$Stock = $_POST['txtStock'];

// Si quieres que `Edificio` sea siempre 1, puedes asignar el valor directamente aquí
$Edificio = 3;

$consulta = "INSERT INTO `materiales` (`Nombre`, `Descripcion`, `Stock`, `EdificioID`) VALUES ('$nombre', '$Descripcion', '$Stock', '$Edificio')";

$resultado = mysqli_query($conn, $consulta) or die("Error de registro: " . mysqli_error($conn));

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: MaterialesNave.php?status=success");
exit();
?>
