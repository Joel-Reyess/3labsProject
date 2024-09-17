<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connection.php');

$nombre = $_POST['txtItemID'];
$matricula = $_POST['txtMatricula'];
$Stock = $_POST['txtStock'];

$Edificio = 1; 
$FechaP = date('Y-m-d H:i:s'); // Obtener la fecha en formato adecuado

// Iniciar una transacción
mysqli_begin_transaction($conn);

try {
    // Verificar el stock actual de la herramienta
    $consultaStock = "SELECT `Stock` FROM `herramientas` WHERE `ItemID` = '$nombre'";
    $resultadoStock = mysqli_query($conn, $consultaStock);
    
    if (!$resultadoStock) {
        throw new Exception("Error al obtener el stock: " . mysqli_error($conn));
    }
    
    $row = mysqli_fetch_assoc($resultadoStock);
    $stockActual = $row['Stock'];

    // Verificar si hay suficiente stock
    if ($stockActual <= 0 || $stockActual < $Stock) {
        // Redirigir a PrestamoH.php con un mensaje de error en la URL
        header("Location: PrestamoH.php?status=error&message=No%20hay%20suficiente%20stock%20disponible");
        exit();
    }

    // Actualizar el Stock en la tabla Materiales
    $consultaUpdate = "UPDATE `herramientas` SET `Stock` = `Stock` - $Stock WHERE `ItemID` = '$nombre'";
    $resultadoUpdate = mysqli_query($conn, $consultaUpdate);
    
    if (!$resultadoUpdate) {
        throw new Exception("Error al actualizar el stock: " . mysqli_error($conn));
    }

    // Insertar en la tabla prestamosmateriales
    $consultaInsert = "INSERT INTO `prestamosherramientas` (`ItemID`, `Matricula`, `EdificioID`, `FechaPrestamo`, `Cantidad`) 
                       VALUES ('$nombre', '$matricula', '$Edificio', '$FechaP', '$Stock')";
    $resultadoInsert = mysqli_query($conn, $consultaInsert);
    
    if (!$resultadoInsert) {
        throw new Exception("Error al insertar el préstamo: " . mysqli_error($conn));
    }

    // Si todo va bien, confirmar la transacción
    mysqli_commit($conn);

    // Redirige a la página anterior con un parámetro de éxito
    header("Location: PrestamoH.php?status=success");
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
