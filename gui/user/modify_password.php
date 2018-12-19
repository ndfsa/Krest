<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30-Nov-18
 * Time: 7:52 PM
 */

$host = $_SERVER['HTTP_HOST'];
session_start();
?>

<html>
<head>
    <meta charset="utf-8">
    <title>krest: database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="../homepage.php">Krest</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="add.php">Añadir contenido</a>
            </li>
            <?php if ($_SESSION["type"] == "Administrador") { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Administrar usuarios
                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="add.php">Add</a>
                        <a class="dropdown-item" href="delete.php">Delete</a>
                    </div>

                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="../login.php?sign_out=true">Cerrar sesión</a>
            </li>
        </ul>
    </div>
</nav>
<br>
<?php
if (isset($_POST['password'])) {
    $curl = curl_init();
    $req_url = 'http://' . $host . '/Krest/services/user_service.php?id_user=' . $_SESSION['id_user'];
    $headers = ['Accept: application/json',
        'Content-Type: application/json',
        'Accept-Encoding: application/json'];
    $data = array_merge($_POST, array('username' => $_SESSION['username'], 'password_change' => true));
    curl_setopt_array($curl, array(
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $req_url,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_CUSTOMREQUEST => 'PUT'
    ));
    curl_exec($curl);
    ?>
    <a href="../homepage.php"
       class="btn btn-primary btn-lg">Volver a inicio</a>
    <?php
} else {
    ?>
    <div class="container-fluid w-100">
        <div class="container">
            <form action="modify_password.php" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Nueva contraseña" aria-label="Contraseña"
                           aria-describedby="basic-addon2" name="password">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Modificar contraseña</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
}
?>
</body>
</html>