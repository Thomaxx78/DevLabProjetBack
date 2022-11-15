<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<header>
    <a href="index.php">Accueil</a>
    <a href="register.php">S'inscrire</a>
    <a href="login.php">Se connecter</a>
</header>

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

