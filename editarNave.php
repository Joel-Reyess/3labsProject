<?php

session_start();
error_reporting(0);
$varsesion= $_SESSION['usuario'];
if($varsesion== null || $varsesion=''){
    header("location: index.php");
    die();
}


include('connection.php');

// Obtener roles
$sql_roles = "SELECT CarreraID, NombreCarrera FROM carreras";
$result_roles = $conn->query($sql_roles);
$carrera = [];
if ($result_roles->num_rows > 0) {
    while ($row = $result_roles->fetch_assoc()) {
        $carrera[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <style>
        @media (max-width: 992px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                margin-bottom: 20px;
            }
        }
    </style>
    <script>
        window.onload = function() {
            // Obtén el parámetro de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            // Si el parámetro status es "success", muestra un mensaje y recarga la página
            if (status === 'success') {
                alert('Registro exitoso. La página se actualizará.');

                // Limpia los parámetros de la URL para que no se siga mostrando el mensaje
                const newUrl = window.location.pathname;
                history.replaceState(null, null, newUrl);

                // Recarga la página
                window.location.reload();
            }
        }
    </script>
</head>

<body>

    <div class="d-flex">
        <nav class="sidebar bg-dark text-white d-flex flex-column p-3">
            <a href="AlumnosNave.php" class="text-white text-decoration-none py-2">Inicio</a>
            <a href="MaterialesNave.php" class="text-white text-decoration-none py-2">Materiales</a>
            <a href="IndexNave.php" class="text-white text-decoration-none py-2">Herramientas</a>
            <a href="PrestamoMNave.php" class="text-white text-decoration-none py-2">Prestamo Materiales</a>
            <a href="PrestamoHNave.php" class="text-white text-decoration-none py-2">Prestamo Herramienta</a>
        </nav>

        <main class="flex-fill" style="margin-left: 250px; padding-top: 20px;">
            <div class="container">

                <?php
                include('connection.php');

                $id = $_GET["id"];

                $sql = "SELECT estudiantes.*, carreras.CarreraID, carreras.NombreCarrera 
                FROM estudiantes 
                JOIN carreras ON estudiantes.CarreraID = carreras.CarreraID 
                WHERE estudiantes.Matricula = '$id'";
                $result = mysqli_query($conn, $sql);



                while ($mostrar = mysqli_fetch_array($result)) {
                    $selectedItemID = $mostrar['CarreraID'];
                ?>
                    <h1 class="text-center">Registro</h1>
                    <form action="procesar_editarNave.php" method="POST">
                        <div class="mb-3">
                            <label for="Matricula" class="form-label">Matricula</label>
                            <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Matricula'] ?>" id="Matricula" name="txtMatricula" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="Nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Nombre'] ?>" id="Nombre" name="txtNombre" Required>
                        </div>
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="Apellido Paterno" class="form-label">Apellido Paterno</label>
                                <input type="text" class="form-control bg-light" value="<?php echo $mostrar['ApellidoP'] ?>" id="ApellidoP" name="txtApellidoP" Required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Apellido Materno" class="form-label">Apellido Materno</label>
                                <input type="text" class="form-control bg-light" value="<?php echo $mostrar['ApellidoM'] ?>" id="ApellidoM" name="txtApellidoM" Required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Correo" class="form-label">Correo</label>
                            <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Correo'] ?>" id="Correo" name="txtCorreo" Required>
                        </div>
                        <div class="form-row row">
                            <div class="form-group col-md-6">
                                <label for="Grado" class="form-label">Grado</label>
                                <input type="Number" class="form-control bg-light" value="<?php echo $mostrar['Grado'] ?>" id="Grado" name="txtGrado" Required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="Grupo" class="form-label">Grupo</label>
                                <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Grupo'] ?>" id="Grupo" name="txtGrupo" Required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Carrera" class="form-label">Carrera</label>
                            <select class="form-control bg-light" id="Rol" name="txtRol" Required>
                                <option value="">Selecciona un material</option>
                                <?php
                                foreach ($carrera as $row) {
                                    $selected = ($row["CarreraID"] == $selectedItemID) ? "selected" : "";
                                    echo "<option value='" . $row["CarreraID"] . "' $selected>" . $row["NombreCarrera"] . "</option>";
                                }
                                ?>
                            </select>
                        </div>


                    <?php
                }
                    ?>

                    <button type="submit" value="Actualizar" class="btn btn-success">Actualizar</button>
                    </form><br>
                    <div class="text-center">
                        <a class="btn btn-danger" href="cerrar_session.php">Cerrar Sesión</a>
                    </div><br>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>

</html>