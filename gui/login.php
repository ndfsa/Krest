<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 09-Nov-18
 * Time: 2:31 PM
 */
?>

<html>
<head>
    <meta charset="utf-8">
    <title>krest: database</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
            integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
            integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-sm-6 bg-primary">
            <div class="row justify-content-center align-items-center h-100 text-white">
                <h1>Krest</h1>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="container-fluid p-5">
                <div class="row justify-content-left align-items-center">
                    <h1>Bienvenido!</h1>
                </div>
                <?php
                session_start();
                if ($_SESSION["signed_in"]) {
                    if ($_GET["sign_out"]) {
                        session_unset();
                        echo '<a href="login.php">Inicia sesión</a>';
                    } else {
                        echo '<a href="homepage.php">Ya inició sesión, ir a la página principal</a>';
                    }

                } else {
                    if (isset($_POST['username'])) {
                        $curl = curl_init();
                        $req_url = 'http://localhost:8080/Krest/services/user_service.php';
                        $headers = ['Accept: application/json',
                            'Content-Type: application/json',
                            'Accept-Encoding: application/json'];
                        curl_setopt_array($curl, array(
                            CURLOPT_HTTPHEADER => $headers,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_URL => $req_url,
                            CURLOPT_POSTFIELDS => json_encode($_POST),
                            CURLOPT_POST => 1
                        ));
                        $res = json_decode(curl_exec($curl), true);
                        if (isset($res['id_user'])) {
                            $_SESSION = array_merge($res, array('signed_in' => true));
                            //var_dump($_SESSION);
                            echo '<br><a href="homepage.php">Ingresa a la página principal</a>';
                        } else {
                            echo '<h1><a href="login.php">Error, Intenta de nuevo</a></h1>';
                        }
                    } else {
                        ?>
                        <div class="container">
                            <form action="login.php" method="post">
                                <div class="form-group">
                                    <label for="userInput">Nombre de usuario</label>
                                    <input type="text" class="form-control" id="userInput" aria-describedby="usernameHelp"
                                           placeholder="Ingrese nombre de Usuario" name="username">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="exampleInputPassword1"
                                           placeholder="Ingrese contraseña"
                                           name="password">
                                    <small id="usernameHelp" class="form-text text-muted">Nunca muestre su contrseña a
                                        nadie.
                                    </small>
                                </div>
                                <button type="submit" class="btn btn-primary">Inicia sesión</button>
                            </form>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
