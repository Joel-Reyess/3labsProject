<?php
include('connection.php');

// Recibir los datos del formulario, asegurando protección contra inyecciones SQL
$ItemID = mysqli_real_escape_string($conn, $_POST['txtItemID']);
$newStock = mysqli_real_escape_string($conn, $_POST['txtStockV']);
$matricula = mysqli_real_escape_string($conn, $_POST['txtMatricula']);
$edificio = mysqli_real_escape_string($conn, $_POST['txtEdificio']);
$id = mysqli_real_escape_string($conn, $_POST['txtPrestamoID']);

// Verificar que `EdificioID` sea un número entero
if (!is_numeric($edificio)) {
    die("Error: El valor de EdificioID no es válido.");
}

// Obtener el `ItemID` y la cantidad actual en `prestamosmateriales`
$query = "SELECT `ItemID`, `Cantidad` FROM `prestamosmateriales` WHERE `PrestamoID` = '$id'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error en la consulta SQL: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
$previousItemID = $row['ItemID']; // `ItemID` anterior
$currentStock = $row['Cantidad'];  // Cantidad anterior

// Obtener el stock actual del nuevo `ItemID`
$queryStock = "SELECT `Stock` FROM `materiales` WHERE `ItemID` = '$ItemID'";
$resultStock = mysqli_query($conn, $queryStock);
if (!$resultStock) {
    die("Error al obtener el stock actual del ItemID: " . mysqli_error($conn));
}
$rowStock = mysqli_fetch_assoc($resultStock);
$currentItemStock = $rowStock['Stock']; // Stock actual del nuevo `ItemID`

// Verificar si la resta del nuevo stock llevaría el stock a un valor negativo
if ($currentItemStock - $newStock < 0) {
    // Mostrar un mensaje de advertencia y detener la ejecución
    echo "<script>
            alert('Error: El stock actual del ItemID $ItemID es $currentItemStock. No puedes prestar más de lo disponible.');
            window.history.back(); // Regresa a la página anterior
          </script>";
    exit();
}

// Si el `ItemID` ha cambiado, restaurar el stock del `ItemID` anterior
if ($previousItemID !== $ItemID) {
    // Restaurar el stock del `ItemID` anterior sumando la cantidad prestada anteriormente
    $consultaRestore = "UPDATE `materiales` SET `Stock` = `Stock` + $currentStock WHERE `ItemID` = '$previousItemID'";
    $resultadoRestore = mysqli_query($conn, $consultaRestore);
    if (!$resultadoRestore) {
        die("Error al restaurar el stock del ItemID anterior: " . mysqli_error($conn));
    }
}

// Actualizar el stock del nuevo `ItemID` restando la nueva cantidad prestada
$consultaUpdate = "UPDATE `materiales` SET `Stock` = `Stock` - $newStock WHERE `ItemID` = '$ItemID'";
$resultadoUpdate = mysqli_query($conn, $consultaUpdate);
if (!$resultadoUpdate) {
    die("Error al actualizar el stock del nuevo ItemID: " . mysqli_error($conn));
}

// Actualizar la tabla `prestamosmateriales` con el nuevo `ItemID`, cantidad y edificio
$sql = "UPDATE `prestamosmateriales` 
        SET `Matricula` = '$matricula', `Cantidad` = '$newStock', `ItemID` = '$ItemID', `EdificioID` = '$edificio'
        WHERE `PrestamoID` = '$id'";

if (mysqli_query($conn, $sql)) {
    // Si la actualización es exitosa, redirigir a la página con un parámetro de éxito
    header("Location: PrestamoMA.php?status=success");
} else {
    // Si ocurre un error, redirigir con un mensaje de error
    $error = mysqli_error($conn);
    header("Location: PrestamoMA.php?status=error&error=" . urlencode($error));
}

// Cerrar la conexión
mysqli_close($conn);
exit();
?>
