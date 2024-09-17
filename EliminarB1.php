<?php
include('connection.php');

if (isset($_POST['btnEliminar'])) {
    $matricula = $_POST['txtMatricula'];

    // Verificar si el estudiante tiene un préstamo asociado
    $sql_check_prestamo = "SELECT COUNT(*) AS total FROM prestamosmateriales WHERE Matricula = '$matricula'";
    $result_check = mysqli_query($conn, $sql_check_prestamo);
    $row_check = mysqli_fetch_assoc($result_check);

    if ($row_check['total'] > 0) {
        // Si tiene préstamos, redirigir con un mensaje de error
        header("Location: AlumnosB1.php?error=No se puede eliminar el estudiante porque tiene un préstamo asociado.");
        exit();
    } else {
        // Si no tiene préstamos, eliminar el registro
        $sql = "DELETE FROM estudiantes WHERE Matricula = '$matricula'";
        if (mysqli_query($conn, $sql)) {
            header("Location: AlumnosB1.php?status=deleted");
            exit();
        } else {
            header("Location: AlumnosB1.php?error=No se pudo eliminar el registro.");
            exit();
        }
    }
}
?>
