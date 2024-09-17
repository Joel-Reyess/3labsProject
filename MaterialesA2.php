<?php

session_start();
error_reporting(0);
$varsesion= $_SESSION['usuario'];
if($varsesion== null || $varsesion=''){
    header("location: index.html");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Materiales</title>
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
            <form action="/">
                <input type="text" placeholder="Buscar" name="search">
                <a class="btn btn-outline-danger" href="cerrar_session.php">Cerrar Sesion</a>
            </form>
        </div>
    </nav>

    <nav class="sidebar" id="sidebar">
        <div id="navegador">

            <ul>
                <li><a href="AlumnosB1.php"><img src="imagenes/casa-icon.png" alt="" srcset=""> Inicio</a>
                </li>
                <li>
                    <a href="MaterialesA2.php"><img src="imagenes/alumno-icon.png" alt="" srcset=""> Consumibles</a>
                </li>
                <li>
                    <a href="IndexA2.php"><img src="imagenes/herramientas.png" alt="" srcset=""> Herramientas</a>
                </li>
                <li>
                    <a href="PrestamoMB1.php"><img src="imagenes/herramientas2.png" alt=""> Prestamo Consumible</a>
                </li>
                <li>
                    <a href="PrestamoHB1.php"><img src="imagenes/herramientas2.png" alt=""> Prestamo Herramienta</a>
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
                            <h4 class="card-title">Materiales</h4>
                            <p class="card-description">
                                Registro de materiales
                            </p>
                            <form class="forms-sample" action="AgregarMaterialA2.php" method="POST">
                                <div class="form-group">
                                    <label for="Nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control bg-light" id="Nombre" name="txtNombre" Required>
                                </div>
                                <div class="form-group">
                                    <label for="Apellidos" class="form-label">Descripcion</label>
                                    <input type="text" class="form-control bg-light" id="Descripcion" name="txtDescripcion" Required>
                                </div>
                                <div class="form-group">
                                    <label for="Correo" class="form-label">Stock</label>
                                    <input type="Number" class="form-control bg-light" id="Stock" name="txtStock" Required>
                                </div>

                                <button type="submit" name="action" value="Subir" class="btn btn-primary mr-2">Subir</button>
                            </form><br>

                            <div class="card-body">
                                <h4 class="card-title">Registro de consumible</h4>
                                <p class="card-description">
                                    <code></code>
                                </p>
                                <div class="table-responsive pt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-info">
                                                <th>Nombre</th>
                                                <th>Descripcion</th>
                                                <th>Stock</th>
                                                <th>Edificio</th>
                                                <th>Editar</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include('connection.php');
                                            $sql = "SELECT materiales.*, edificios.NombreEdificio FROM materiales 
                        JOIN edificios ON materiales.EdificioID = edificios.EdificioID 
                        WHERE materiales.EdificioID = 2";
                                            $result = mysqli_query($conn, $sql);

                                            while ($mostrar = mysqli_fetch_array($result)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $mostrar['Nombre'] ?></td>
                                                    <td><?php echo $mostrar['Descripcion'] ?></td>
                                                    <td><?php echo $mostrar['Stock'] ?></td>
                                                    <td><?php echo $mostrar['NombreEdificio'] ?></td>
                                                    <td>
                                                        <a class="btn btn-primary" href="editarMaterialA2.php?id=<?php echo $mostrar['ItemID'] ?>">Editar</a>
                                                    </td>
                                                    <td>
                                                        <form action="EliminarMaterialA2.php" method="post">
                                                            <input type="hidden" value="<?php echo $mostrar['ItemID'] ?>" name="txtItemID">
                                                            <input class="btn btn-danger" type="submit" value="Eliminar" name="btnEliminar" onclick='return confirmo()'>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <br>
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

</html>