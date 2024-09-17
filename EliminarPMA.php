<?php
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['PrestamoID'])) {
        $prestamoID = $_POST['PrestamoID'];

        $sql = "DELETE FROM prestamosmateriales WHERE PrestamoID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $prestamoID);

        if ($stmt->execute()) {
            header("Location: PrestamoMA.php?status=eliminado"); // Redirige a la página original con un indicador de éxito
            exit();
        } else {
            echo "Error al eliminar el registro.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>
