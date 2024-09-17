<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connection.php');

$nombre = $_POST['txtItemID'];
$matricula = $_POST['txtMatricula'];
$Stock = $_POST['txtStock'];

$Edificio = 3;
$FechaP = date('Y-m-d H:i:s'); // Obtener la fecha en formato adecuado

// Iniciar una transacción
mysqli_begin_transaction($conn);

try {
    // Actualizar el Stock en la tabla Materiales
    $consultaUpdate = "UPDATE `materiales` SET `Stock` = `Stock` - $Stock WHERE `ItemID` = '$nombre'";
    $resultadoUpdate = mysqli_query($conn, $consultaUpdate);
    if (!$resultadoUpdate) {
        throw new Exception("Error al actualizar el stock: " . mysqli_error($conn));
    }

    // Insertar en la tabla prestamosmateriales
    $consultaInsert = "INSERT INTO `prestamosmateriales` (`ItemID`, `Matricula`, `EdificioID`, `FechaPrestamo`, `Cantidad`) 
                       VALUES ('$nombre', '$matricula', '$Edificio', '$FechaP', '$Stock')";
    $resultadoInsert = mysqli_query($conn, $consultaInsert);
    if (!$resultadoInsert) {
        throw new Exception("Error al insertar el préstamo: " . mysqli_error($conn));
    }

    // Si todo va bien, confirmar la transacción
    mysqli_commit($conn);

    // Redirige a la página anterior con un parámetro de éxito
    header("Location: PrestamoMNave.php?status=success");
    exit();

} catch (Exception $e) {
    // Si hay un error, deshacer la transacción
    mysqli_rollback($conn);

    // Mostrar el error
    die($e->getMessage());
}

// Cerrar la conexión
mysqli_close($conn);
?>
