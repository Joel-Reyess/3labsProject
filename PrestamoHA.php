<?php

session_start();
error_reporting(0);
$varsesion= $_SESSION['usuario'];
if($varsesion== null || $varsesion=''){
    header("location: index.html");
    die();
}

include('connection.php');

$selectedItemID = '';
$stock = '';

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['txtItemID'])) {
        $selectedItemID = $_POST['txtItemID'];

        // Obtener el stock del ItemID seleccionado
        $sql_stock = "SELECT Stock FROM herramientas WHERE ItemID = ?";
        $stmt = $conn->prepare($sql_stock);
        $stmt->bind_param("s", $selectedItemID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stock = $row['Stock'];
        }
        $stmt->close();
    }
}

// Obtener roles y herramientas para los select
$sql_roles1 = "SELECT ItemID, Nombre, Descripcion, Stock FROM herramientas";
$result_roles1 = $conn->query($sql_roles1);

$sql_roles = "SELECT Matricula, CONCAT(Nombre, ' ', ApellidoP, ' ', ApellidoM) AS NombreCompleto FROM estudiantes";
$result_roles = $conn->query($sql_roles);

$sql_roles2 = "SELECT EdificioID, NombreEdificio FROM edificios";
$result_roles2 = $conn->query($sql_roles2);

if (isset($_GET['status']) && $_GET['status'] == 'error') {
    $message = urldecode($_GET['message']);
    echo "<script type='text/javascript'>alert('$message');</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="bodysection.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamo herramientas</title>

    <script>
        function updateStock() {
            var itemID = document.getElementById("txtItemID").value;

            if (itemID !== "") {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "get_stockh.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        console.log("Respuesta recibida: " + xhr.responseText);
                        document.getElementById("txtStockV").value = xhr.responseText;
                    }
                };

                xhr.send("itemID=" + itemID);
            } else {
                document.getElementById("txtStockV").value = "";
            }
        }
    </script>

    <script>
        window.onload = function() {
            // Obtén los parámetros de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const error = urlParams.get('error');

            // Si el parámetro status es "success", muestra un mensaje y recarga la página
            if (status === 'success') {
                alert('Registro exitoso. La página se actualizará.');

                // Limpia los parámetros de la URL para que no se siga mostrando el mensaje
                const newUrl = window.location.pathname;
                history.replaceState(null, null, newUrl);

                // Recarga la página
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

        function confirmo() {
            var respuesta = confirm("¿Esta seguro de eliminar este registro?");
            if (respuesta == true) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="index.html"><img src="imagenes/uttn_logo.jpg" alt="Logo"></a>
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
                <li>
                    <a href="Alumnos.php"><img src="imagenes/casa-icon.png" alt="" srcset=""> Inicio</a>
                </li>
                <li>
                    <a href="Usuarios.php"><img src="imagenes/alumno-icon.png" alt="" srcset=""> Usuarios</a>
                </li>
                <li>
                    <a href="herramientas.php"><img src="imagenes/alumno-icon.png" alt="" srcset=""> Consumibles</a>
                </li>
                <li>
                    <a href="IndexA.php"><img src="imagenes/herramientas.png" alt="" srcset=""> Herramientas</a>
                </li>
                <li>
                    <a href="PrestamoMA.php"><img src="imagenes/herramientas2.png" alt=""> Prestamo Consumible</a>
                </li>
                <li>
                    <a href="PrestamoHA.php"><img src="imagenes/herramientas2.png" alt=""> Prestamo Herramienta</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 col-lg-12  grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Prestamo</h4>
                            <p class="card-description">
                                Registro de prestamo
                            </p>
                            <form class="forms-sample" action="AgregarPrestamoHA.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="txtItemID" class="form-label">Material</label>
                                        <select class="form-control bg-light" id="txtItemID" name="txtItemID" onchange="updateStock()">
                                            <option value="">Selecciona un material</option>
                                            <?php
                                            if ($result_roles1->num_rows > 0) {
                                                while ($row = $result_roles1->fetch_assoc()) {
                                                    $selected = ($row["ItemID"] == $selectedItemID) ? "selected" : "";
                                                    echo "<option value='" . $row["ItemID"] . "' $selected>" . $row["Nombre"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <input type="hidden" class="form-control bg-light" id="txtStockV" name="txtStockV" value="<?php echo $stock; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-row row">
                                    <div class="form-group col-md-6">
                                        <label class="form-label">Cantidad Solicitada</label>
                                        <input type="text" class="form-control bg-light" id="txtStock" name="txtStock">
                                    </div>
                                    <div class="form-group col-md-6">

                                        <label for="Matricula" class="form-label">Matricula</label>
                                        <select class="form-control bg-light" id="txtMatricula" name="txtMatricula">
                                            <?php
                                            if ($result_roles->num_rows > 0) {
                                                while ($row = $result_roles->fetch_assoc()) {
                                                    echo "<option value='" . $row["Matricula"] . "'>" . $row["NombreCompleto"] . "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <br>
                                </div>
                                <div class="form-group">
                                    <label for="Apellidos" class="form-label">Edificio</label>
                                    <select class="form-control bg-light" id="Rol" name="txtEdificio">
                                        <?php
                                        if ($result_roles2->num_rows > 0) {
                                            while ($row = $result_roles2->fetch_assoc()) {
                                                echo "<option value='" . $row["EdificioID"] . "'>" . $row["NombreEdificio"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <br>
                                <button type="submit" name="action" value="Subir" class="btn btn-primary mr-2">Subir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include('connection.php');

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
        JOIN carreras ON estudiantes.CarreraID = carreras.CarreraID ";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="card-body">
            <h4 class="card-title">Registro de Prestamos</h4>
            <p class="card-description">
                Prestamo
            </p>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-info">
                            <th>Material</th>
                            <th>Descripción</th>
                            <th>Estudiante</th>
                            <th>Carrera</th>
                            <th>Edificio</th>
                            <th>Fecha Prestamo</th>
                            <th>Fecha devolucion</th>
                            <th>Estado</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr>

                                <td><?php echo $row['NombreHerramienta'] ?></td>
                                <td><?php echo $row['Descripcion'] ?></td>
                                <td><?php echo $row['NombreEstudiante'] ?></td>
                                <td><?php echo $row['NombreCarrera'] ?></td>
                                <td><?php echo $row['NombreEdificio'] ?></td>
                                <td><?php echo $row['FechaPrestamo'] ?></td>
                                <td><?php echo $row['FechaDevolucion'] ?></td>
                                <td>
                                    <form id="estadoForm<?php echo $row['PrestamoID']; ?>" action="procesar_estado.php" method="post">
                                        <input type="hidden" name="PrestamoID" value="<?php echo $row['PrestamoID']; ?>">
                                        <input class="switch" type="checkbox" id="estadoCheckbox<?php echo $row['PrestamoID']; ?>" name="estado" <?php echo ($row['Estado'] == 'activo') ? 'checked' : ''; ?>>
                                    </form>
                                </td>
                                <script>
                                    // Asigna la función al evento clic del checkbox
                                    document.getElementById('estadoCheckbox<?php echo $row['PrestamoID']; ?>').addEventListener('click', function() {
                                        document.getElementById('estadoForm<?php echo $row['PrestamoID']; ?>').submit();
                                        this.disabled = true; // Desactiva el checkbox después de hacer clic
                                    });
                                </script>
                                <td>
                                    <a class="btn btn-primary" href="editarPHA.php?id=<?php echo $row['PrestamoID'] ?>">Editar</a>
                                </td>
                                <td>
                                    <form action="EliminarPHA.php" method="post">
                                        <input type="hidden" value="<?php echo $row['PrestamoID'] ?>" name="PrestamoID">
                                        <input class="btn btn-danger" type="submit" value="Eliminar" name="btnEliminar" onclick='return confirmo()'>
                                    </form>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <script>
            document.getElementById('toggleSidebar').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('hide');
                document.querySelector('.main-panel').classList.toggle('full-width');
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#txtMatricula').select2({
                    placeholder: 'Busca una matrícula o nombre...',
                    allowClear: true
                });
            });

            $(document).ready(function() {
                $('#txtItemID').select2({
                    placeholder: 'Busca una Material...',
                    allowClear: true
                });
            });
        </script>

</body>

</html>