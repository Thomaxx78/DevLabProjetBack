<?php
    require_once 'class/user.php';
    require_once 'class/album.php';
    require_once 'class/connection.php';
    $connection = new Connection();

    if ($_POST) {
        $user = new User(
                $_POST['email'],
                $_POST['password'],
                $_POST['username'],
                $_POST['description'],
                $_POST['age'],
                $_FILES['logo']['name'],
        );
        var_dump($user);
        $img_name = $_FILES['logo']['name'];
        $tmp_img_name = $_FILES['logo']['tmp_name'];
        $folder = 'images/avatars/';
        move_uploaded_file($tmp_img_name,$folder.$img_name);

        if ($user->verify()) {
            if ($connection->insert($user)) {
                $user_id = $connection->pdo->lastInsertId();

                $albumV = new Album("Visionnés", "public", $user_id);
                $albumE = new Album("Liste Envies", "public", $user_id);
                if ($albumV->verify() && $albumE->verify()) {
                    $query = "INSERT INTO album (name, privacy, user_id) VALUES (?, ?, ?)";
                    $stmt = $connection->pdo->prepare($query);
                    $stmt->execute([$albumV->name, $albumV->privacy, $albumV->user_id]);
                    $stmt->execute([$albumE->name, $albumE->privacy, $albumE->user_id]);

                    header(('Location: login.php'));
                } else {
                    echo 'Internal error 🥲';
                }
            }
        }
    }
?>

<?php require_once 'require/head.php';?>

<body>
    <?php require_once 'require/nav.php';?>
    <h1>S'inscrire</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="email">Adresse Mail</label>
        <input type="email" name="email" placeholder="Entrer votre adresse mail">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" placeholder="Entrer un mot de passe">
        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" placeholder="Entrer votre nom d'utilisateur">

        <label for="description">Description</label>
        <textarea type="text" name="description" id="description" rows=1 COLS=40 placeholder="Ajouter la description de la carte"></textarea>

        <label for="age">Age</label>
        <input type="text" name="age" placeholder="Entrer votre âge">

        <div>
            <img src="images/icons/add_image.png" alt="">
            <p>PNG ou JPG inférieur à 5MB</p>
            <div>
                <input id="file" type="file" accept="image/png, image/jpeg" name="logo" class="inputfile" data-multiple-caption="{count} files selected" multiple >
                <label for="file" class="custom-file-upload"><span>Selectioner un fichier&hellip;</span></label>
            </div>
        </div>

        <button type="submit" class="btn">Submit</button>
    </form>
    <p> Déjà un compte ? Connectez-vous <a href="login.php"> ici</a>.</p>


    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
    <script src="js/custom-file-input.js"></script>
</body>
</html>

