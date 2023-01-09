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

    <div class="mt-16 h-auto bg-white rounded-lg p-4 border-8 lg:w-4/12 w-10/12 mx-auto">
    <p class="text-2xl text-darkgrey font-semibold text-center">Se connecter</p>
    <form method="POST" class="mt-8 text-center">
        <input class="mx-auto border-b border-b-lightgrey" type="email" name="email" placeholder="E-mail"><br>
        <input class="m-auto border-b border-b-lightgrey mt-2" type="password" name="password" placeholder="Password"><br>
        <div class="rounded-lg border border-black mt-4 p-1 w-4/12 lg:w-4/12 m-auto hover:bg-violetwe hover:text-white hover:border-violetwe text-center">
            <button class="" type="submit" name="login">Connexion</button>
        </div>
        </form>    
        <p class="text-center mt-4">Pas encore de compte ?<a href="login.php" class="text-violetwe text-center"> Inscrivez-vous.</a></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>

