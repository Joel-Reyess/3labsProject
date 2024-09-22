<?php
session_start();
session_destroy();

// Redirigir a la página de inicio de sesión u otra página después de cerrar sesión
header("location: index.php");

?>
