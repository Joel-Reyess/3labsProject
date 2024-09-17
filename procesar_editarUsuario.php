<?php
include('connection.php');

$matricula = $_POST['txtMatricula'];
$nombre = $_POST['txtNombre'];
$ApellidoP = $_POST['txtApellidoP'];
$ApellidoM = $_POST['txtApellidoM'];
$Contraseña = $_POST['txtContraseña'];
$Rol = $_POST['txtRol'];


$resultado = mysqli_query($conn, "UPDATE `usuarios` SET  `Nombre` = '$nombre', `ApellidoP` = '$ApellidoP',`ApellidoM` = '$ApellidoM', `Contraseña` = '$Contraseña', `RolID` = '$Rol'
WHERE `Matricula` = '$matricula'") or die("error");

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: Usuarios.php?status=success");
exit();
?>
