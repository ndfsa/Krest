<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 18-Nov-18
 * Time: 5:35 PM
 */

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
<nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-4">
    <a class="navbar-brand" href="homepage.php">Krest</a>

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="#">Link 3</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="login.php?sign_out=true">Cerrar sesión</a>
        </li>
    </ul>
</nav>
<div class="container-fluid w-100">
    <div class="container">
        <?php
        if (isset($_POST['title'])) {
            $curl = curl_init();
            $req_url = 'http://localhost:8080/Krest/services/content_service.php';
            $headers = ['Accept: application/json',
                'Content-Type: application/json',
                'Accept-Encoding: application/json'];
            $data = array_merge($_POST, array('id_user' => $_SESSION['id_user']));
            curl_setopt_array($curl, array(
                CURLOPT_HTTPHEADER => $headers,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => $req_url,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_POST => 1
            ));
            curl_exec($curl);
            ?>
            <a href="homepage.php"
               class="btn btn-primary btn-lg">Volver a inicio</a>
            <?php
        } else {
            ?>
            <form action="add.php" method="post">
                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" class="form-control" id="title" placeholder="Título" name="title">
                </div>
                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="text" class="form-control" id="url" placeholder="URL" name="url">
                </div>
                <div class="form-group">
                    <label for="inputState">Estado</label>
                    <select id="inputState" class="form-control" name="state">
                        <option selected>Choose...</option>
                        <option>Oculto</option>
                        <option>Normal</option>
                        <option>Principal</option>
                        <option>Urgente</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea class="form-control" id="description" rows="3" name="description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Añadir</button>
            </form>
            <?php
        }
        ?>
    </div>
</div>
</body>
</html>
