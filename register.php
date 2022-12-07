<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<header>
    <a href="index.php">Accueil</a>
    <a href="register.php">S'inscrire</a>
    <a href="login.php">Se connecter</a>
</header>

<body>

<div class="inscrire">
    <h1>S'inscrire:</h1><br>
    <form method="post" >
        <input type="text" name="pseudo" placeholder="pseudo"><br>
        <input type="email" name="email" placeholder="E-mail"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <input type="submit" value="Register" name="inscrire">
    </form>
</div>

<?php
require_once 'class/user.php';
require_once 'class/connection.php';

if ($_POST) {
    $user = new User(
        $_POST['pseudo'],
        $_POST['email'],
        $_POST['password']
    );

    if ($user->verify()) {
        // save to database
        $connection = new Connection();
        $result = $connection->insert($user);

        if ($result) {
            echo 'Registered with success!';
        } else {
            echo 'Internal error 🥲';
        }
    } else {
        echo 'Form has an error';
    }
} ?>
</body>
</html>