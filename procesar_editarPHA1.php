<?php
include('connection.php');

// Recibir los datos del formulario, asegurando protección contra inyecciones SQL
$ItemID = mysqli_real_escape_string($conn, $_POST['txtItemID']);
$newStock = mysqli_real_escape_string($conn, $_POST['txtStockV']);
$matricula = mysqli_real_escape_string($conn, $_POST['txtMatricula']);
$id = mysqli_real_escape_string($conn, $_POST['txtPrestamoID']);
$FechaCreacion = date('Y-m-d H:i:s');


// Obtener el estado del préstamo y otros datos en `prestamosherramientas`
$query = "SELECT `ItemID`, `Cantidad`, `Estado` FROM `prestamosherramientas` WHERE `PrestamoID` = '$id'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error en la consulta SQL: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
$previousItemID = $row['ItemID']; // `ItemID` anterior
$currentStock = $row['Cantidad'];  // Cantidad anterior
$estado = $row['Estado'];          // Estado del préstamo

// Verificar si el estado es "inactivo"
if ($estado === 'inactivo') {
    echo "<script>
            alert('Error: No se puede actualizar este préstamo porque está inactivo.');
            window.history.back();
          </script>";
    exit();
}

// Obtener el stock actual del nuevo `ItemID`
$queryStock = "SELECT `Stock` FROM `herramientas` WHERE `ItemID` = '$ItemID'";
$resultStock = mysqli_query($conn, $queryStock);
if (!$resultStock) {
    die("Error al obtener el stock actual del ItemID: " . mysqli_error($conn));
}
$rowStock = mysqli_fetch_assoc($resultStock);
$currentItemStock = $rowStock['Stock']; // Stock actual del nuevo `ItemID`

// Verificar si la resta del nuevo stock llevaría el stock a un valor negativo
if ($currentItemStock - $newStock < 0) {
    echo "<script>
            alert('Error: El stock actual del ItemID $ItemID es $currentItemStock. No puedes prestar más de lo disponible.');
            window.history.back();
          </script>";
    exit();
}

// Si el `ItemID` ha cambiado, restaurar el stock del `ItemID` anterior
if ($previousItemID !== $ItemID) {
    $consultaRestore = "UPDATE `herramientas` SET `Stock` = `Stock` + $currentStock WHERE `ItemID` = '$previousItemID'";
    $resultadoRestore = mysqli_query($conn, $consultaRestore);
    if (!$resultadoRestore) {
        die("Error al restaurar el stock del ItemID anterior: " . mysqli_error($conn));
    }
}

// Actualizar el stock del nuevo `ItemID` restando la nueva cantidad prestada
$consultaUpdate = "UPDATE `herramientas` SET `Stock` = `Stock` - $newStock WHERE `ItemID` = '$ItemID'";
$resultadoUpdate = mysqli_query($conn, $consultaUpdate);
if (!$resultadoUpdate) {
    die("Error al actualizar el stock del nuevo ItemID: " . mysqli_error($conn));
}

// Actualizar la tabla `prestamosherramientas` con el nuevo `ItemID`, cantidad, edificio y fecha de préstamo
$sql = "UPDATE `prestamosherramientas` 
        SET `Matricula` = '$matricula', `Cantidad` = '$newStock', `ItemID` = '$ItemID', 
             `FechaPrestamo` = NOW()
        WHERE `PrestamoID` = '$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: PrestamoHA1.php?status=success");
} else {
    $error = mysqli_error($conn);
    header("Location: PrestamoHA1.php?status=error&error=" . urlencode($error));
}

// Cerrar la conexión
mysqli_close($conn);
exit();
