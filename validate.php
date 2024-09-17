<?php
$usuario=$_POST['usuario'];
$contraseña=$_POST['contraseña'];
session_start();
$_SESSION['usuario']=$usuario;

$conexion=mysqli_connect("localhost","root","","proyect");

$consulta="SELECT*FROM usuarios where Matricula='$usuario' and Contraseña='$contraseña'";
$resultado=mysqli_query($conexion,$consulta);

$filas=mysqli_fetch_array($resultado);

if($filas['RolID']==1){ //A1
    header("location:IndexA1.php");

}else
if($filas['RolID']==2){ //A2
header("location:IndexA2.php");
}
else
if($filas['RolID']==3){ //Nave
header("location:IndexNave.php");
}
else
if($filas['RolID']==4){ //Admin
header("location:IndexAdmin.php");
}
else{
    ?>
    <?php
    include("index.html");
    ?>
    <h1 class="bad">ERROR EN LA AUTENTIFICACION</h1>
    <?php
}
mysqli_free_result($resultado);
mysqli_close($conexion);
