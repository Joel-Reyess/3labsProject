<?php
include('connection.php');

// Recibir los datos del formulario
$ItemID = $_POST['txtItemID'];
$newStock = $_POST['txtStockV'];
$matricula = $_POST['txtMatricula'];
$id = $_POST['txtPrestamoID'];

// Obtener el `ItemID` y la cantidad actual en `prestamosmateriales`
$query = "SELECT `ItemID`, `Cantidad` FROM `prestamosmateriales` WHERE `PrestamoID` = '$id'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Error en la consulta SQL: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($result);
$previousItemID = $row['ItemID']; // Obtener el `ItemID` anterior
$currentStock = $row['Cantidad'];  // Obtener la cantidad anterior

// Obtener el stock actual del nuevo `ItemID` en la tabla `materiales`
$queryStock = "SELECT `Stock` FROM `materiales` WHERE `ItemID` = '$ItemID'";
$resultStock = mysqli_query($conn, $queryStock);
if (!$resultStock) {
    die("Error en la consulta SQL del stock: " . mysqli_error($conn));
}
$rowStock = mysqli_fetch_assoc($resultStock);
$currentItemStock = $rowStock['Stock']; // Stock actual del nuevo `ItemID`

// Verificar si el stock será negativo
if ($currentItemStock < $newStock) {
    // En lugar de mostrar un mensaje simple con echo, genera un script de JavaScript para mostrar un alert
    echo "<script>
            alert('Error: El stock actual del Item es de: $currentItemStock. No puedes prestar más de lo disponible.');
            window.history.back(); // Vuelve a la página anterior después de mostrar el mensaje
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

// Actualizar la tabla `prestamosmateriales` con el nuevo `ItemID`, cantidad y matricula
$sql = "UPDATE `prestamosmateriales` 
        SET `Matricula` = '$matricula', `Cantidad` = '$newStock', `ItemID` = '$ItemID' 
        WHERE `PrestamoID` = '$id'";

if (mysqli_query($conn, $sql)) {
    // Si la actualización es exitosa, redirigir a la página con un parámetro de éxito
    header("Location: PrestamoMNave.php?status=success");
} else {
    // Si ocurre un error, redirigir con un mensaje de error
    $error = mysqli_error($conn);
    header("Location: PrestamoMNave.php?status=error&error=" . urlencode($error));
}

// Cerrar la conexión
mysqli_close($conn);
exit();
?>
