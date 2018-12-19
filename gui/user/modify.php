<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 30-Nov-18
 * Time: 7:52 PM
 */

session_start();
$host = $_SERVER['HTTP_HOST'];
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
                        <a class="dropdown-item" href="delete_middle.php">Delete</a>
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
<div class="container-fluid w-100">
    <div class="container">
        <?php
        if (isset($_POST['name'])) {
            $curl = curl_init();
            $req_url = 'http://' . $host . '/Krest/services/user_service.php?id_user=' . $_GET['id_user'];
            $headers = ['Accept: application/json',
                'Content-Type: application/json',
                'Accept-Encoding: application/json'];
            curl_setopt_array($curl, array(
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $req_url,
                CURLOPT_POSTFIELDS => json_encode($_POST),
                CURLOPT_CUSTOMREQUEST => 'POST'
            ));
            curl_exec($curl);
            ?>
            <a href="../homepage.php"
               class="btn btn-primary btn-lg">Volver a inicio</a>
            <?php
        } else {
            if (isset($_GET['username'])) {
                $curl = curl_init();
                $req_url = 'http://' . $host . '/Krest/services/user_service.php?username=' . $_GET['username'];
                $headers = ['Accept: application/json',
                    'Content-Type: application/json',
                    'Accept-Encoding: application/json'];
                curl_setopt_array($curl, array(
                    CURLOPT_HTTPHEADER => $headers,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $req_url,
                    CURLOPT_CUSTOMREQUEST => 'GET'
                ));
                $res = json_decode(curl_exec($curl), true);
                //var_dump($res);
                ?>
                <form action="modify.php?id_user=<?php echo $res['id_user']; ?>" method="post">
                    <div class="form-group">
                        <label for="name">Nombre(s)</label>
                        <input type="text" class="form-control" id="name" placeholder="Nombre(s)" name="name"
                               value="<?php echo $res['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="surname">Apellido(s)</label>
                        <input type="text" class="form-control" id="surname" placeholder="Apellido(s)" name="surname"
                               value="<?php echo $res['surname']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="username">Nombre de usuario</label>
                        <input type="text" class="form-control" id="username" placeholder="Nombre de usuario"
                               name="username" value="<?php echo $res['username']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="type">Tipo de usuario</label>
                        <select id="type" class="form-control" name="type">
                            <option selected><?php echo $res['type']; ?></option>
                            <option>Administrador</option>
                            <option>Moderador</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Fecha de nacimiento</label>
                        <input type="date" class="form-control" id="date" name="birth"
                               value="<?php echo $res['birth']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Modificar</button>
                </form>

                <?php
            } else {
                echo "<p1>No se encontró el usuario</p1>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>

