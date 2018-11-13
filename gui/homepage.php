<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 09-Nov-18
 * Time: 1:11 PM
 */

session_start();
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
<?php
if ($_SESSION["signed_in"]) {
//if(true){
    ?>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark mb-4">
        <a class="navbar-brand" href="homepage.php">Krest</a>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">Añadir contenido</a>
            </li>
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
            <form action="homepage.php" method="get">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Contenido..." aria-label="Búsqueda"
                           aria-describedby="basic-addon2" name="search">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                    </div>
                </div>
            </form>
            <table class="table table-bordered table-dark">
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>URL</th>
                    <th>Estado</th>
                    <th>Descripción</th>
                </tr>
                <?php
                if (isset($_GET["search"])) {
                    $search = $_GET["search"];
                } else {
                    $search = "";
                }
                $curl = curl_init();
                $req_url = 'http://localhost:8080/Krest/services/content_service.php?search=' . $search;
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
                foreach ($res as $index => $element) {
                    ?>
                    <tr>
                        <?php
                        echo '<th>' . $element["id_content"] . '</th>';
                        echo '<th>' . $element["title"] . '</th>';
                        echo '<th>' . $element["url"] . '</th>';
                        echo '<th>' . $element["state"] . '</th>';
                        echo '<th>' . $element["description"] . '</th>';
                        ?>
                        <th>
                            <a class="btn btn-danger btn-sm" href="<?php
                            echo "#" . $index;?>" role="button">Eliminar</a>
                        </th>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="container-fluid w-100">
        <div class="row justify-content-center align-items-center h-25">
            <h1>No ha iniciado sesión</h1>
        </div>
        <div class="row justify-content-center align-items-center h-75">
            <a class="btn btn-primary" href="login.php" role="button">Inicia sesión!</a>
        </div>
    </div>
    <?php
}
?>
</body>
</html>