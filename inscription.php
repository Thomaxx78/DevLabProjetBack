<?php require 'require/head.php' ?>

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