<?php
session_start();
?>

<?php require 'require/head.php';?>
<?php require 'require/nav.php';?>

<body class="bg-violetwe">
    <div class="mt-16 lg:w-3/12 w-10/12 h-auto bg-white ml-auto mr-auto text-center rounded-lg p-4 border-8">
    <h1 class="text-2xl text-darkgrey font-semibold">Se connecter</h1>
        <form method="POST" class="mt-8 flex flex-col items-center">
            <input type="text" name="email" placeholder="E-mail" class="shadow p-1">
            <input type="password" name="password" placeholder="Password" class="shadow p-1">
            <button type="submit" name="login" class="bg-violetwe text-white mt-4 px-2 rounded-lg p-1 shadow">Connexion</button>
        </form>
    <p class="mt-4">Pas encore membre ? <a href="signin.php" class="text-violetwe font-semibold">Inscrivez vous.</a></p>
    </div>

    <?php 
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

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>

