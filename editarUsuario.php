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
$sql_roles = "SELECT RolID, NombreRol FROM roles";
$result_roles = $conn->query($sql_roles);
$rol = [];
if ($result_roles->num_rows > 0) {
    while ($row = $result_roles->fetch_assoc()) {
        $rol[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bodysection.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Informacion Usuario</title>

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

                <li>
                    <a href="Alumnos.php"><img src="imagenes/casa-icon.png" alt="" srcset=""> Inicio</a>
                </li>
                <li>
                    <a href="Usuarios.php"><img src="imagenes/alumno-icon.png" alt="" srcset=""> Usuarios</a>
                </li>
                <li>
                    <a href="Materiales.php"><img src="imagenes/alumno-icon.png" alt="" srcset=""> Consumibles</a>
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
                            <h4 class="card-title">Herramientas</h4>
                            <p class="card-description">
                                Registro de Alumnos
                            </p>

                            <?php
                            include('connection.php');

                            $id = $_GET["id"];

                            $sql = "SELECT usuarios.*, roles.RolID, roles.NombreRol 
    FROM usuarios JOIN roles ON usuarios.RolID = roles.RolID
    where usuarios.Matricula= '$id'";
                            $result = mysqli_query($conn, $sql);

                            while ($mostrar = mysqli_fetch_array($result)) {
                                $selectedItemID = $mostrar['RolID'];
                            ?>


                                <form class="forms-sample" action="procesar_editarUsuario.php" method="POST">
                                    <div class="form-group">
                                        <label for="Matricula" class="form-label">Matricula</label>
                                        <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Matricula'] ?>" id="Matricula" name="txtMatricula">
                                    </div>
                                    <div class="form-group">
                                        <label for="Nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Nombre'] ?>" id="Nombre" name="txtNombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="Apellidos" class="form-label">Apellido Parteno</label>
                                        <input type="text" class="form-control bg-light" value="<?php echo $mostrar['ApellidoP'] ?>" id="Apellidos" name="txtApellidoP">
                                    </div>
                                    <div class="form-group">
                                        <label for="Apellidos" class="form-label">Apellido Materno</label>
                                        <input type="text" class="form-control bg-light" value="<?php echo $mostrar['ApellidoM'] ?>" id="Apellidos" name="txtApellidoM">
                                    </div>
                                    <div class="form-group">
                                        <label for="Correo" class="form-label">Contraseña</label>
                                        <input type="password" class="form-control bg-light" value="<?php echo $mostrar['Contraseña'] ?>" id="Correo" name="txtContraseña">
                                    </div>
                                    <div class="form-group">
                                        <label for="Correo" class="form-label">Rol</label>
                                        <select class="form-control bg-light" id="Rol" name="txtRol">
                                            <?php
                                            foreach ($rol as $row) {
                                                $selected = ($row["RolID"] == $selectedItemID) ? "selected" : "";
                                                echo "<option value='" . $row["RolID"] . "' $selected>" . $row["NombreRol"] . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php
                            }
                                ?>

                                <button type="submit" value="Actualizar" class="btn btn-success">Actualizar</button>
                                </form><br>

                        </div>
                        <br>
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