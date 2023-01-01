<?php
session_start();
?>

<?php 
require 'require/head.php';
require 'require/nav.php';
require_once 'class/connection.php';
require_once 'class/user.php'; 

if($_POST){
    if(isset($_POST['login'])){
        $connection = new Connection();
        $email = $_POST['email'];
        $user = $connection->log($email);

        if(md5($_POST['password'] . 'SALT' ) === $user['password']){
            $_SESSION['email'] = $user['email'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['description'] = $user['description'];
            $_SESSION['age'] = $user['age'];
            $_SESSION['logo'] = $user['logo'];
            $_SESSION['id'] = $user['id'];
            if (isset($_SESSION['username'])) {
                header('Location: dashboard.php');
            }
        }   
    else {
        echo 'Erreur connexion';
    }
}}
?>

<body class="bg-violetwe">
    <!-- <div class="bg-darkgrey flex flex-col lg:w-3/12 ml-auto mr-auto text-center rounded-lg p-4 border-8 border-white">
    <h1 class="text-2xl text-white font-semibol">Se connecter</h1>
        <form method="POST" class="flex flex-col">
            <label for="email" class="text-violetwe">Adresse Mail</label>
            <input type="text" name="email" placeholder="Entrer votre adresse mail">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" placeholder="Entrer votre mot de passe">
            <button type="submit" name="login">Submit</button>
        </form>
    <p>Pas encore membre ? <a href="signin.php" class="text-violetwe">Inscrivez vous.</a></p>
    </div> -->

    <div class="mt-16 w-3/12 h-auto bg-white ml-auto mr-auto text-center rounded-lg p-4 border-8 border-darkgrey">
    <p class="text-2xl text-darkgrey font-semibold">Se connecter</p>
    <form method="POST" class="mt-8">
        <input type="email" name="email" placeholder="E-mail"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <button class="bg-darkgrey text-darkgrey mt-4 px-2 rounded-lg" type="submit" name="login">Connexion</button>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>

