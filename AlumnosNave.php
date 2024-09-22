<?php
session_start();
error_reporting(0);
$varsesion = $_SESSION['usuario'];
if ($varsesion == null || $varsesion = '') {
    header("location: index.html");
    die();
}

include('connection.php');

// Obtener roles
$sql_roles = "SELECT CarreraID, NombreCarrera FROM carreras";
$result_roles = $conn->query($sql_roles);

?>
<?php if (!empty($_GET['error'])): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
<?php elseif (!empty($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="alert alert-success">Registro exitoso.</div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamo de herramientas</title>
    <link rel="stylesheet" href="bodysection.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
        <form action="AlumnosNave.php" method="GET">
                <input type="text" placeholder="Buscar" name="search" onkeydown="if (event.key === 'Enter') { this.form.submit(); }">

                <a class="btn btn-outline-danger" href="cerrar_session.php">Cerrar Sesion</a>
            </form>
        </div>
    </nav>

    <nav class="sidebar" id="sidebar">
        <div id="navegador">

            <ul>
                <li><a href="AlumnosNave.php"><img src="imagenes/casa-icon.png" alt="" srcset=""> Inicio</a>
                </li>
                <li>
                    <a href="MaterialesNave.php"><img src="imagenes/alumno-icon.png" alt="" srcset=""> Consumibles</a>
                </li>
                <li>
                    <a href="IndexNave.php"><img src="imagenes/herramientas.png" alt="" srcset=""> Herramientas</a>
                </li>
                <li>
                    <a href="PrestamoMNave.php"><img src="imagenes/herramientas2.png" alt=""> Prestamo Consumible</a>
                </li>
                <li>
                    <a href="PrestamoHNave.php"><img src="imagenes/herramientas2.png" alt=""> Prestamo Herramienta</a>
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
                            <h4 class="card-title">Herramientas</h4>
                            <p class="card-description">
                                Registro de Alumnos
                            </p>

                            <form class="forms-sample" action="registroAlumnoB1.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="Matricula" class="form-label">Matricula</label>
                                    <input type="text" class="form-control bg-light" id="Matricula" name="txtMatricula" minlength="8" required>
                                    <?php if (!empty($error)): ?>
                                        <div class="alert alert-danger mt-2"><?php echo $error; ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="Nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control bg-light" id="Nombre" name="txtNombre" Required>
                                </div>
                                <div class="form-row row">
                                    <div class="form-group col-md-6">
                                        <label for="Apellidos" class="form-label">Apellido Paterno</label>
                                        <input type="text" class="form-control bg-light" id="Apellidos" name="txtApellidoP" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="Apellidos" class="form-label">Apellido Materno</label>
                                        <input type="text" class="form-control bg-light" id="Apellidos" name="txtApellidoM" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Correo" class="form-label">Correo</label>
                                    <input type="email" class="form-control bg-light" id="Correo" name="txtCorreo" required>
                                </div>
                                <div class="form-group">
                                    <div class="form-row row">
                                        <div class="form-group col-md-6">
                                            <label for="Grado" class="form-label">Grado</label>
                                            <input type="number" class="form-control bg-light" id="Grado" name="txtGrado" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="Grupo" class="form-label">Grupo</label>
                                            <input type="text" class="form-control bg-light" id="Grupo" name="txtGrupo" minlength="1" Required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Carrera" class="form-label">Carrera</label>
                                    <select class="form-control bg-light" id="Rol" name="txtCarrera">
                                        <?php
                                        if ($result_roles->num_rows > 0) {
                                            while ($row = $result_roles->fetch_assoc()) {
                                                echo "<option value='" . $row["CarreraID"] . "'>" . $row["NombreCarrera"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" name="action" value="Subir" class="btn btn-primary mr-2">Subir</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <h4 class="card-title">Registro de Alumnos</h4>
            <p class="card-description">
                <code></code>
            </p>
            <div class="table-responsive pt-3">
                <table class="table table-bordered">
                    <thead>
                        <tr class="table-info">
                            <th>Matricula</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Grado</th>
                            <th>Grupo</th>
                            <th>Carrera</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include('connection.php');

                        // Capturar el término de búsqueda
                        $search = isset($_GET['search']) ? $_GET['search'] : '';

                        // Modificar la consulta SQL para filtrar los resultados
                        $sql = "SELECT estudiantes.*, carreras.NombreCarrera FROM estudiantes 
        JOIN carreras ON estudiantes.CarreraID = carreras.CarreraID";

                        if (!empty($search)) {
                            $sql .= " WHERE estudiantes.Matricula LIKE '%$search%' 
              OR estudiantes.Nombre LIKE '%$search%'
              OR estudiantes.ApellidoP LIKE '%$search%'
              OR estudiantes.ApellidoM LIKE '%$search%'
              OR carreras.NombreCarrera LIKE '%$search%'";
                        }

                        $result = mysqli_query($conn, $sql);

                        while ($mostrar = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td><?php echo $mostrar['Matricula'] ?></td>
                                <td><?php echo $mostrar['Nombre'] . ' ' . $mostrar['ApellidoP'] . ' ' . $mostrar['ApellidoM'] ?></td>
                                <td><?php echo $mostrar['Correo'] ?></td>
                                <td><?php echo $mostrar['Grado'] ?></td>
                                <td><?php echo $mostrar['Grupo'] ?></td>
                                <td><?php echo $mostrar["NombreCarrera"]; ?></td>
                                <td>
                                    <a class="btn btn-primary" href="editarA.php?id=<?php echo $mostrar['Matricula'] ?>">Editar</a>
                                </td>
                                <td>
                                    <form action="EliminarA.php" method="post">
                                        <input type="hidden" value="<?php echo $mostrar['Matricula'] ?>" name="txtMatricula">
                                        <input type="submit" class="btn btn-danger" value="Eliminar" name="btnEliminar" onclick='return confirmo()'>
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

    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        document.getElementById('toggleSidebar').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('hide');
            document.querySelector('.main-panel').classList.toggle('full-width');
        });
    </script>
</body>