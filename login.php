<?php
session_start();
?>

<?php require 'require/head.php';?>
<?php require 'require/nav.php';?>

<body>
    <h1>Connexion</h1>
    <form method="POST">
        <label for="email">Adresse Mail</label>
        <input type="text" name="email" placeholder="Entrer votre adresse mail">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Entrer votre mot de passe">
        <button type="submit" name="login">Submit</button>
    </form>
    <p>Pas encore membre ? Inscrivez vous <a href="signin.php"> ici</a>.</p>

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
                $_SESSION['role'] = $user['role'];
                $_SESSION['id'] = $user['id'];
                if($_SESSION['role'] == 1){
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

