<?php
/**
 * Created by PhpStorm.
 * User: sergi
 * Date: 14-Nov-18
 * Time: 8:59 PM
 */
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
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a class="dropdown-item" href="#">Add</a>
                        <a class="dropdown-item" href="#">Modify</a>
                        <a class="dropdown-item" href="#">Delete</a>
                    </div>

                </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" href="../login.php?sign_out=true">Cerrar sesión</a>
            </li>
        </ul>
    </div>
</nav><br>
<div class="container-fluid w-100">
    <div class="container">
        <?php
        if (isset($_GET['id_content'])) {
            $curl = curl_init();
            $req_url = 'http://localhost:8080/Krest/services/content_service.php?id_content=' . $_GET['id_content'];
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
            if (isset($res['id_content'])) {
                ?>
                <div class="d-flex justify-content-between">
                    <div class="p-2">
                        <h3>Usted está por eliminar:</h3><br>
                        <ul class="list-group">
                            <?php
                            echo "<li class='list-group-item'>" . $res['id_content'] . "</li>";
                            echo "<li class='list-group-item'>" . $res['title'] . "</li>";
                            echo "<li class='list-group-item'>" . $res['url'] . "</li>";
                            echo "<li class='list-group-item'>" . $res['state'] . "</li>";
                            echo "<li class='list-group-item'>" . $res['description'] . "</li>";
                            ?>
                        </ul>
                    </div>
                    <div class="p-2">
                        <a href="delete.php?delete=<?php echo $res['id_content']; ?>"
                           class="btn btn-danger btn-lg">Eliminar</a>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <h1>No se encontró tal contenido</h1>
                <?php
            }
        } else {
            if (isset($_GET['delete'])) {
                $curl = curl_init();
                $req_url = 'http://localhost:8080/Krest/services/content_service.php?id_content=' . $_GET['delete'];
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $req_url,
                    CURLOPT_CUSTOMREQUEST => 'DELETE'
                ));
                curl_exec($curl);
                ?>
                <a href="../homepage.php"
                   class="btn btn-primary btn-lg">Volver a inicio</a>
                <?php
            }
        }
        ?>
    </div>
</div>
</body>
</html>
