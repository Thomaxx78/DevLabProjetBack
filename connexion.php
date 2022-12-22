<?php require 'require/head.php' ?>

<h1>Se connecter:</h1><br>
<form method="post" >
    <input type="email" name="email" placeholder="E-mail"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="submit" value="Register" name="connect">
</form>

<?php

require 'class/connection.php';
require 'class/userconnect.php';

if ($_POST) {
    $user = new userconnect(
        $_POST['email'],
        $_POST['password'],
    );
    $connection = new Connection();
    if ($connection->recuperationAccount($user)) {
        header("Location: index.php");
        $_SESSION["normal"] = $user;
        $_SESSION['id'] = $connection->recuperationId($user);
    }
}