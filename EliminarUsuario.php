<?php 
include('connection.php');

$Matricula=$_POST['txtMatricula'];
mysqli_query($conn, "DELETE FROM usuarios where Matricula= '$Matricula'") or die ("error al eliminar");

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: Usuarios.php?status=success");
exit();
?>
