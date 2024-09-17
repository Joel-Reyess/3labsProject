<?php
include('connection.php');

$matricula = $_POST['txtMatricula'];
$nombre = $_POST['txtNombre'];
$ApellidoP = $_POST['txtApellidoP'];
$ApellidoM = $_POST['txtApellidoM'];
$Correo = $_POST['txtCorreo'];
$Grado = $_POST['txtGrado'];
$Grupo = $_POST['txtGrupo'];
$Carrera = $_POST['txtCarrera'];


$resultado = mysqli_query($conn, "UPDATE `estudiantes` SET `Matricula` = '$matricula', `Nombre` = '$nombre', `ApellidoP` = '$ApellidoP',`ApellidoM` = '$ApellidoM', `Correo` = '$Correo', `Grado` = '$Grado', `Grupo` = '$Grupo', `CarreraID` = '$Carrera'
WHERE `Matricula` = '$matricula'") or die("error");

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: AlumnosNave.php?status=success");
exit();
?>
