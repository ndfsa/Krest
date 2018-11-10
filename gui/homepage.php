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
</head>
<body>
<?php
if ($_SESSION["signed_in"]) {
//if(true){
    ?>
    <div>
        <a href="login.php?sign_out=true">sign out!</a>
    </div>
    <div>
        <form action="homepage.php" method="get">
            <input type="text" name="search"/>
            <input type="submit" value="search"/>
        </form>
        <table>
            <tr>
                <th>id</th>
                <th>title</th>
                <th>url</th>
                <th>state</th>
                <th>description</th>
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
            foreach ($res as $element) {
                ?>
                <tr>
                    <?php
                    echo '<th>' . $element["id_content"] . '</th>';
                    echo '<th>' . $element["title"] . '</th>';
                    echo '<th>' . $element["url"] . '</th>';
                    echo '<th>' . $element["state"] . '</th>';
                    echo '<th>' . $element["description"] . '</th>';
                    ?>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <?php
} else {
    echo '<h1>NO USER HAS SIGNED IN :C</h1>';
    echo '<h2><a href="login.php">sign in!</a></h2>';
}
?>
</body>
</html>