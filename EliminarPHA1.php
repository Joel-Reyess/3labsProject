<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['PrestamoID'])) {
        $prestamoID = $_POST['PrestamoID'];

        // Primero obtenemos el estado del préstamo y la herramienta relacionada
        $sql = "SELECT Estado, ItemID FROM prestamosherramientas WHERE PrestamoID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $prestamoID);
        $stmt->execute();
        $stmt->bind_result($estado, $herramientaID);
        $stmt->fetch();
        $stmt->close();

        // Si el estado es 'activo', devolvemos el stock a la tabla herramientas
        if ($estado === 'activo') {
            $sqlUpdateStock = "UPDATE herramientas SET stock = stock + 1 WHERE ItemID = ?";
            $stmt = $conn->prepare($sqlUpdateStock);
            $stmt->bind_param("i", $herramientaID);
            $stmt->execute();
            $stmt->close();
        }

        // Ahora eliminamos el registro de la tabla prestamosherramientas
        $sqlDelete = "DELETE FROM prestamosherramientas WHERE PrestamoID = ?";
        $stmt = $conn->prepare($sqlDelete);
        $stmt->bind_param("i", $prestamoID);

        if ($stmt->execute()) {
            header("Location: PrestamoHA1.php?status=eliminado");
            exit();
        } else {
            echo "Error al eliminar el registro.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

