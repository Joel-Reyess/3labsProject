<?php

session_start();
error_reporting(0);
$varsesion= $_SESSION['usuario'];
if($varsesion== null || $varsesion=''){
    header("location: index.php");
    die();
}

include('connection.php');

// Obtener roles y materiales para los select
$sql_roles1 = "SELECT ItemID, Nombre, Descripcion, Stock, EdificioID FROM herramientas WHERE EdificioID = 1";
$result_roles1 = $conn->query($sql_roles1);

// Almacenar el resultado en un array para su uso posterior
$materiales = [];
if ($result_roles1->num_rows > 0) {
    while ($row = $result_roles1->fetch_assoc()) {
        $materiales[] = $row;
    }
}

$sql_roles = "SELECT Matricula, CONCAT(Nombre, ' ', ApellidoP, ' ', ApellidoM) AS NombreCompleto FROM estudiantes";
$result_roles = $conn->query($sql_roles);

// Almacenar los estudiantes en un array
$estudiantes = [];
if ($result_roles->num_rows > 0) {
    while ($row = $result_roles->fetch_assoc()) {
        $estudiantes[] = $row;
    }
}


?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bodysection.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Prestamo Info</title>
    <script>
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const error = urlParams.get('error');

            if (status === 'success') {
                alert('Registro exitoso. La página se actualizará.');
                const newUrl = window.location.pathname;
                history.replaceState(null, null, newUrl);
                window.location.reload();
            } else if (status === 'deleted') {
                alert('Registro eliminado con éxito.');
                const newUrl = window.location.pathname;
                history.replaceState(null, null, newUrl);
            } else if (error) {
                alert(error);
                const newUrl = window.location.pathname;
                history.replaceState(null, null, newUrl);
            }
        }
    </script>
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="imagenes/uttn_logo.jpg" alt="Logo"></a>
            </div>
        </div>
    </header>
    <nav class="navbar">
        <button id="toggleSidebar" class="btn btn-primary">☰</button>
        <div class="search-container">
            <form action="/">
                <input type="text" placeholder="Buscar" name="search">
                <a class="btn btn-outline-danger" href="cerrar_session.php">Cerrar Sesion</a>
            </form>
        </div>
    </nav>

    <nav class="sidebar" id="sidebar">
        <div id="navegador">
            <ul>
                <li><a href="AlumnosA1.php"><img src="imagenes/casa-icon.png" alt="" srcset=""> Inicio</a>
                </li>
                <li>
                    <a href="MaterialesA1.php"><img src="imagenes/alumno-icon.png" alt="" srcset=""> Consumibles</a>
                </li>
                <li>
                    <a href="IndexA1.php"><img src="imagenes/herramientas.png" alt="" srcset=""> Herramientas</a>
                </li>
                <li>
                    <a href="PrestamoM.php"><img src="imagenes/herramientas2.png" alt=""> Prestamo Consumible</a>
                </li>
                <li>
                    <a href="PrestamoH"><img src="imagenes/herramientas2.png" alt=""> Prestamo Herramienta</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main-panel">
        <?php
        $id = $_GET["id"];
        $sql = "SELECT 
            prestamosherramientas.*, 
            herramientas.Nombre AS NombreHerramienta, 
            herramientas.Descripcion, 
            estudiantes.Matricula, 
            CONCAT(estudiantes.Nombre, ' ', estudiantes.ApellidoP, ' ', estudiantes.ApellidoM) AS NombreEstudiante, 
            carreras.NombreCarrera, edificios.NombreEdificio
        FROM prestamosherramientas 
        JOIN herramientas ON prestamosherramientas.ItemID = herramientas.ItemID
        JOIN edificios ON prestamosherramientas.EdificioID = edificios.EdificioID
        JOIN estudiantes ON prestamosherramientas.Matricula = estudiantes.Matricula
        JOIN carreras ON estudiantes.CarreraID = carreras.CarreraID
            WHERE PrestamoID = '$id'";
        $result = mysqli_query($conn, $sql);

        while ($mostrar = mysqli_fetch_array($result)) {
            $selectedItemID = $mostrar['ItemID'];
            $selectedMatricula = $mostrar['Matricula'];
            $selectedEdificio = $mostrar['EdificioID'];
        ?>
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 col-lg-12  grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Herramientas</h4>
                                <form class="forms-sample" action="procesar_editarPHA.php" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control bg-light" id="txtStockV" name="txtPrestamoID" value="<?php echo $mostrar['PrestamoID']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtItemID" class="form-label">Herramienta</label>
                                        <select class="form-control bg-light" id="txtItemID" name="txtItemID">
                                            <option value="">Selecciona un herramienta</option>
                                            <?php
                                            foreach ($materiales as $row) {
                                                $selected = ($row["ItemID"] == $selectedItemID) ? "selected" : "";
                                                echo "<option value='" . $row["ItemID"] . "' $selected>" . $row["Nombre"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="txtStockV" class="form-label">Cantidad</label>
                                        <input type="text" class="form-control bg-light" id="txtStockV" name="txtStockV" value="<?php echo $mostrar['Cantidad']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Estudiante</label>
                                        <select class="form-control bg-light" name="txtMatricula">
                                            <option value="">Selecciona un estudiante</option>
                                            <?php
                                            foreach ($estudiantes as $row) {
                                                $selected = ($row["Matricula"] == $selectedMatricula) ? "selected" : "";
                                                echo "<option value='" . $row["Matricula"] . "' $selected>" . $row["NombreCompleto"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                            </div>
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            </form>
                        <?php
                    }
                        ?>


                        </div>
                    </div>
                </div>
            </div>
    </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>


</body>

</html>