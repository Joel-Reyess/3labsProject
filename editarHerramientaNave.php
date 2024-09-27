<?php
session_start();
error_reporting(0);
$varsesion= $_SESSION['usuario'];
if($varsesion== null || $varsesion=''){
    header("location: index.php");
    die();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herramientas Info</title>
    <link rel="stylesheet" href="bodysection.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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

        <?php
        include('connection.php');

        $id = $_GET["id"];

        $sql = "SELECT * FROM herramientas where ItemID= '$id'";
        $result = mysqli_query($conn, $sql);


        while ($mostrar = mysqli_fetch_array($result)) {
        ?>

            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 col-lg-12  grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Herramientas Info</h4>
                                <p class="card-description">
                                    Registro de herramientas
                                </p>
                                <form class="forms-sample" action="procesar_editarHNave.php" method="POST">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control bg-light" value="<?php echo $mostrar['ItemID'] ?>" id="Nombre" name="txtItemID">
                                    </div>
                                    <div class="form-group">
                                        <label for="Nombre" class="form-label">Numero de Serie</label>
                                        <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Nombre'] ?>" id="Nombre" name="txtNS" Required>
                                    </div>
                                    <div class="form-group">
                                        <label for="Nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Nombre'] ?>" id="Nombre" name="txtNombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="Descripcion" class="form-label">Descripcion</label>
                                        <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Descripcion'] ?>" id="Descripcion" name="txtDescripcion">
                                    </div>
                                    <div class="form-group">
                                        <label for="Stock" class="form-label">Stock</label>
                                        <input type="text" class="form-control bg-light" value="<?php echo $mostrar['Stock'] ?>" id="Stock" name="txtStock">
                                    </div>
                                <?php
                            }
                                ?>

                                <button type="submit" value="Actualizar" class="btn btn-success">Actualizar</button>
                                </form><br>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>