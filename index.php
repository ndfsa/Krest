<?php
/**
 * Created by PhpStorm.
 * User: Sergio
 * Date: 08-Nov-18
 * Time: 7:37 PM
 */

$curl = curl_init();
$req_url = 'http://localhost:8080/Krest/services/content_service.php?id_content=test';
$headers = ['Accept: application/json',
    'Content-Type: application/json',
    'Accept-Encoding: application/json'];
curl_setopt_array($curl, array(
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $req_url,
));
?>
<html>
<head>
    <title>krest: database</title>
</head>
<body>
<table>
    <tr>
        <th>id</th>
        <th>title</th>
        <th>url</th>
        <th>state</th>
        <th>description</th>
    </tr>
    <?php
    $res = json_decode(curl_exec($curl), true);
    foreach ($res as $element) {
        ?>
        <tr>
            <?php
            echo '<th>'. $element["id_content"] . '</th>';
            echo '<th>'. $element["title"] . '</th>';
            echo '<th>'. $element["url"] . '</th>';
            echo '<th>'. $element["state"] . '</th>';
            echo '<th>'. $element["description"] . '</th>';
            ?>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>
