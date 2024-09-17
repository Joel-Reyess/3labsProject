<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connection.php');

// Obtener datos del formulario
$Matricula = $_POST['txtMatricula'];
$Nombre = $_POST['txtNombre'];
$ApellidoP = $_POST['txtApellidoP'];
$ApellidoM = $_POST['txtApellidoM'];
$Correo = $_POST['txtCorreo'];
$Grado = $_POST['txtGrado'];
$Grupo = $_POST['txtGrupo'];
$Carrera = $_POST['txtCarrera'];

// Verificar si la matrícula ya existe
$sql_check = "SELECT * FROM estudiantes WHERE Matricula = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $Matricula);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Si la matrícula ya existe, redirigir con un mensaje de error
    header("Location: AlumnosB1.php?error=Matrícula%20ya%20registrada");
    exit();
} else {
    // Si la matrícula no existe, proceder con la inserción
    $consulta = "INSERT INTO `estudiantes` (`Matricula`, `Nombre`, `ApellidoP`, `ApellidoM`, `Correo`, `Grado`, `Grupo`, `CarreraID`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt_insert = $conn->prepare($consulta);
    $stmt_insert->bind_param("ssssssss", $Matricula, $Nombre, $ApellidoP, $ApellidoM, $Correo, $Grado, $Grupo, $Carrera);

    if ($stmt_insert->execute()) {
        // Redirige a la página anterior con un parámetro de éxito
        header("Location: AlumnosB1.php?status=success");
    } else {
        // Redirige a la página anterior con un mensaje de error en caso de fallo en la inserción
        header("Location: AlumnosB1.php?error=Error%20al%20registrar");
    }

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
exit();
?>
