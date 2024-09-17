<?php 
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connection.php');
session_start();

// Recibir los datos del formulario
$PrestamoID = mysqli_real_escape_string($conn, $_POST['PrestamoID']);
$nuevo_Estado = (isset($_POST['estado']) && ($_POST['estado'] == 'on' || $_POST['estado'] == '1')) ? 'activo' : 'inactivo';

// Iniciar una transacción
mysqli_begin_transaction($conn);

try {
    // Obtener la cantidad de herramientas prestadas y el ID de la herramienta
    $sql_cantidad = "SELECT Cantidad, ItemID FROM prestamosherramientas WHERE PrestamoID='$PrestamoID'";
    $resultado = mysqli_query($conn, $sql_cantidad);
    
    if (!$resultado) {
        throw new Exception("Error al obtener los datos del préstamo: " . mysqli_error($conn));
    }
    
    $prestamo = mysqli_fetch_assoc($resultado);
    $cantidad = $prestamo['Cantidad'];
    $ItemID = $prestamo['ItemID'];

    // Actualizar el estado y la FechaDevolucion según el nuevo estado
    if ($nuevo_Estado == 'inactivo') {
        // Sumar la cantidad al stock cuando el estado es inactivo
        $FechaDevolucion = date('Y-m-d H:i:s');
        $sql = "UPDATE prestamosherramientas 
                SET Estado='$nuevo_Estado', FechaDevolucion='$FechaDevolucion' 
                WHERE PrestamoID='$PrestamoID'";
        
        $sql_stock = "UPDATE herramientas 
                      SET Stock = Stock + $cantidad 
                      WHERE ItemID='$ItemID'";
    } else {
        // Restar la cantidad del stock cuando el estado es activo
        $sql = "UPDATE prestamosherramientas 
                SET Estado='$nuevo_Estado', FechaDevolucion=NULL 
                WHERE PrestamoID='$PrestamoID'";
        
        $sql_stock = "UPDATE herramientas 
                      SET Stock = Stock - $cantidad 
                      WHERE ItemID='$ItemID'";
    }

    // Ejecutar las consultas de actualización
    if (!mysqli_query($conn, $sql)) {
        throw new Exception("Error al actualizar el estado: " . mysqli_error($conn));
    }
    
    if (!mysqli_query($conn, $sql_stock)) {
        throw new Exception("Error al actualizar el stock: " . mysqli_error($conn));
    }

    // Confirmar la transacción si no hubo errores
    mysqli_commit($conn);

    // Redirigir después de la actualización
    header("Location: PrestamoHB1.php?status=success");
    exit();
} catch (Exception $e) {
    // Deshacer la transacción en caso de error
    mysqli_rollback($conn);

    // Mostrar el mensaje de error
    die($e->getMessage());
}

// Cerrar la conexión
mysqli_close($conn);
exit();
?>

