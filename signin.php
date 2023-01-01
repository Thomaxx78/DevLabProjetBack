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
                $albumE = new Album("Liste Envies ", "public", $user_id);
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


<body class="bg-violetwe">
    <?php require_once 'require/nav.php';?>

    <div class="mt-16 h-auto bg-white rounded-lg p-4 border-8 lg:w-6/12 w-10/12 mx-auto">
        <h1 class="text-2xl text-darkgrey font-semibold text-center">S'inscrire</h1>
        <form method="POST" enctype="multipart/form-data" class="flex flex-col mt-8">
            <div class="grid lg:grid-cols-2 grid-cols-1">
                <div>
                    <h1 class="text-lg font-semibold">Vos informations:</h1>
                    <div class="shadow p-1 rounded-lg flex flex-col mx-3 mt-4">
                        <label for="email" class="font-semibold">Adresse Mail:</label>
                        <input type="email" name="email" placeholder="Entrer votre adresse mail">
                    </div>
                    <div class="shadow p-1 rounded-lg mt-2 flex flex-col mx-3">
                        <label for="password" class="font-semibold">Mot de passe:</label>
                        <input type="password" name="password" placeholder="Entrer un mot de passe">
                    </div>
                    <div class="shadow p-1 rounded-lg mt-2 flex flex-col mx-3">
                        <label for="age" class="font-semibold">Votre age:</label>
                        <input type="text" name="age" placeholder="Entrer votre âge">
                    </div>
                </div>
                <div>
                <h1 class="text-lg font-semibold mt-4 lg:mt-0">Votre profil Delimovie:</h1>
                    <div class="shadow p-1 rounded-lg flex flex-col mx-3 mt-4">
                        <label for="username" class="font-semibold">Nom d'utilisateur:</label>
                        <input type="text" name="username" placeholder="Entrer votre nom d'utilisateur">
                    </div>
                    <div class="shadow p-1 rounded-lg mt-2 flex flex-col mx-3">
                        <label for="description" class="font-semibold">Description:</label>
                        <textarea type="text" name="description" id="description" rows=1 COLS=40 placeholder="Ajouter la description de la carte"></textarea>
                    </div>
                    <div class="shadow p-1 rounded-lg mt-2 flex flex-col mx-3">
                        <input id="file" type="file" accept="image/png, image/jpeg" name="logo" class="inputfile" data-multiple-caption="{count} files selected" multiple >
                        <label for="file" class="custom-file-upload flex flex-col"><span>Selectioner un fichier&hellip;</span></label>
                    </div>
                </div>
            </div>

                <button type="submit" class="btn rounded-lg border border-black mt-4 p-1 w-4/12 lg:w-2/12 m-auto">Submit</button>

        </form>
        <p class="text-center mt-4"> Déjà un compte ?<a href="login.php" class="text-violetwe text-center"> Connectez-vous.</a></p>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
    <script src="js/custom-file-input.js"></script>
</body>
</html>

