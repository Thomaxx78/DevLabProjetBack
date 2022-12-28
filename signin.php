<?php require 'require/head.php';?>
<?php require 'require/nav.php';?>

<body>

    <h1>S'inscrire</h1>
    <form method="post">
        <label for="email">Adresse Mail</label>
        <input type="email" name="email" placeholder="Entrer votre adresse mail">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Entrer un mot de passe">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" placeholder="Entrer votre nom d'utilisateur">

        <button type="submit" class="btn">Submit</button>
    </form>
    <p> Déjà un compte ? Connectez-vous <a href="login.php"> ici</a>.</p>



    <?php
        require_once 'class/user.php';
        require_once 'class/connection.php';

        if ($_POST) {
            $user = new User(
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['username'],
            );

            if ($user->verify()) {
                $connection = new Connection();
                $result = $connection->insert($user);

                if ($result) {
                    header('Location: login.php');
                } else {
                    echo 'Internal error 🥲';
                }
            } else {
                echo 'Form has an error';
            }
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>

