<?php
include('connection.php');

if (isset($_POST['btnEliminar'])) {
    $matricula = $_POST['txtItemID'];

    // Verificar si el estudiante tiene un préstamo asociado
    $sql_check_prestamo = "SELECT COUNT(*) AS total FROM prestamosherramientas WHERE Matricula = '$matricula'";
    $result_check = mysqli_query($conn, $sql_check_prestamo);
    $row_check = mysqli_fetch_assoc($result_check);

    if ($row_check['total'] > 0) {
        // Si tiene préstamos, redirigir con un mensaje de error
        header("Location: IndexA.php?error=No se puede eliminar el estudiante porque tiene un préstamo asociado.");
        exit();
    } else {
        // Si no tiene préstamos, eliminar el registro
        $sql = "DELETE FROM herramientas where ItemID= '$ItemID'";
        if (mysqli_query($conn, $sql)) {
            header("Location: IndexA.php?status=deleted");
            exit();
        } else {
            header("Location: IndexA.php?error=No se pudo eliminar el registro.");
            exit();
        }
    }
}
?>
