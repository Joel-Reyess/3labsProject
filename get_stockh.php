<?php
include('connection.php');

if (isset($_POST['itemID'])) {
    $itemID = $_POST['itemID'];

    // Obtener el stock del ItemID seleccionado
    $sql_stock = "SELECT Stock FROM herramientas WHERE ItemID = ?";
    $stmt = $conn->prepare($sql_stock);
    $stmt->bind_param("s", $itemID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['Stock']; // Devuelve el stock como respuesta
    } else {
        echo "0"; // Si no se encuentra el material, devolver 0 o un valor apropiado
    }

    $stmt->close();
}
?>
