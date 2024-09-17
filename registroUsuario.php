<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connection.php');

$Matricula = $_POST['txtMatricula'];
$Nombre = $_POST['txtNombre'];
$ApellidoP = $_POST['txtApellidoP'];
$ApellidoM = $_POST['txtApellidoM'];
$Contraseña = $_POST['txtContraseña'];
$Rol = $_POST['txtRol'];


$consulta = "INSERT INTO `usuarios` (`Matricula`,`Nombre`, `ApellidoP`, `ApellidoM`, `Contraseña`, `RolID`)
VALUES ('$Matricula', '$Nombre', '$ApellidoP','$ApellidoM','$Contraseña', '$Rol')";

$resultado = mysqli_query($conn, $consulta) or die("error de registro");

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: usuarios.php?status=success");
exit();
?>
