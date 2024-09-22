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
$sql_roles = "SELECT RolID, NombreRol FROM roles";
$result_roles = $conn->query($sql_roles);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
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
            <form action="Usuarios.php" method="GET">
                <input type="text" placeholder="Buscar" name="search" onkeydown="if (event.key === 'Enter') { this.form.submit(); }">

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
                    <a href="Alumnos.php"><img src="imagenes/alumno-icon.png" alt="" srcset=""> Alumnos</a>
                </li>
                <li>
                    <a href="Usuarios.php"><img src="imagenes/alumno-icon.png" alt="" srcset=""> Usuarios</a>
                </li>
                <li>
                    <a href="Materiales.php"><img src="imagenes/herramientas.png" alt="" srcset=""> Consumibles</a>
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
                            <h4 class="card-title">Agregar Alumno</h4>
                            <p class="card-description">
                                Coloque la informacion del alumno
                            </p>
                            <form class="forms-sample" action="registroUsuario.php" method="POST">
                                <div class="form-group">
                                    <label for="Matricula" class="form-label">Matricula</label>
                                    <input type="number" class="form-control bg-light" id="Matricula" name="txtMatricula" Required>
                                </div>
                                <div class="form-group">
                                    <label for="Matricula" class="form-label">Nombre(s)</label>
                                    <input type="text" class="form-control bg-light" id="Matricula" name="txtNombre" Required>
                                </div>
                                <div class="form-group">
                                    <label for="Matricula" class="form-label">Apellido Paterno</label>
                                    <input type="text" class="form-control bg-light" id="Matricula" name="txtApellidoP" Required>
                                </div>
                                <div class="form-group">
                                    <label for="Nombre" class="form-label">Apellido Materno</label>
                                    <input type="text" class="form-control bg-light" id="Nombre" name="txtApellidoM" Required>
                                </div>
                                <div class="form-group">
                                    <label for="Nombre" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control bg-light" id="Nombre" name="txtContraseña" Required>
                                </div>
                                <div class="form-group">
                                    <label for="Apellidos" class="form-label">Rol</label>
                                    <select class="form-control bg-light" id="Rol" name="txtRol">
                                        <?php
                                        if ($result_roles->num_rows > 0) {
                                            while ($row = $result_roles->fetch_assoc()) {
                                                echo "<option value='" . $row["RolID"] . "'>" . $row["NombreRol"] . "</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success">Usuarios</button>
                            </form><br>

                            <div class="card-body">
                                <h4 class="card-title">Registro de Usuarios</h4>
                                <p class="card-description">
                                    <code></code>
                                </p>
                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-info">
                                                <th>Matricula</th>
                                                <th>Nombre</th>
                                                <th>Rol</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include('connection.php');

                                            // Capturar el término de búsqueda de manera segura
                                            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                                            // Consulta SQL para obtener usuarios y sus roles
                                            $sql = "SELECT usuarios.*, roles.NombreRol FROM usuarios 
            JOIN roles ON usuarios.RolID = roles.RolID";

                                            // Si hay un término de búsqueda, agregar el filtro a la consulta
                                            if (!empty($search)) {
                                                $sql .= " WHERE usuarios.Matricula LIKE '%$search%' 
                  OR usuarios.Nombre LIKE '%$search%' 
                  OR usuarios.ApellidoP LIKE '%$search%' 
                  OR usuarios.ApellidoM LIKE '%$search%' 
                  OR roles.NombreRol LIKE '%$search%'";
                                            }

                                            // Ejecutar la consulta
                                            $result = mysqli_query($conn, $sql);

                                            // Verificar si la consulta fue exitosa
                                            if (!$result) {
                                                die("Error en la consulta: " . mysqli_error($conn));
                                            }

                                            // Bucle para mostrar los resultados
                                            while ($mostrar = mysqli_fetch_array($result)) { // Este bucle itera sobre los resultados

                                            ?>
                                                <tr>
                                                    <td><?php echo $mostrar['Matricula'] ?></td>
                                                    <td><?php echo $mostrar['Nombre'] . ' ' . $mostrar['ApellidoP'] . ' ' . $mostrar['ApellidoM'] ?></td>
                                                    <td><?php echo $mostrar["NombreRol"]; ?></td>
                                                    <td>
                                                        <a class="btn btn-primary" href="editarUsuario.php?id=<?php echo $mostrar['Matricula'] ?>">Editar</a>
                                                    </td>
                                                    <td>
                                                        <form action="EliminarUsuario.php" method="post">
                                                            <input type="hidden" value="<?php echo $mostrar['Matricula'] ?>" name="txtMatricula">
                                                            <input class="btn btn-danger" type="submit" value="Eliminar" name="btnEliminar" onclick='return confirmo()'>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            } // Fin del bucle while
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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