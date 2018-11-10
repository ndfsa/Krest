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
</head>
<body>
WELCOME
<?php
session_start();
if ($_SESSION["signed_in"]) {
    if ($_GET["sign_out"]) {
        session_unset();
        echo '<a href="login.php">sign in!</a>';
    } else {
        echo '<a href="homepage.php">already signed in, go to homepage</a>';
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
        $_SESSION = array_merge($res, array('signed_in' => true));
        //var_dump($_SESSION);
        echo '<a href="homepage.php"> go to homepage</a>';

    } else {
        ?>
        <form action="login.php" method="post">
            <input type="text" name="username"/>
            <input type="password" name="password"/>
            <input type="submit" value="login"/>
        </form>
        <?php
    }
    //echo '<a href="homepage.php">go to homepage</a>';
}
?>
</body>
</html>
