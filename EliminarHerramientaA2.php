<?php 
include('connection.php');

$ItemID=$_POST['txtItemID'];
mysqli_query($conn, "DELETE FROM herramientas where ItemID= '$ItemID'") or die ("error al eliminar");

mysqli_close($conn);

// Redirige a la página anterior con un parámetro de éxito
header("Location: IndexA2.php?status=success");
exit();
?>
