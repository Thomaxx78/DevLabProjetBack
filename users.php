<?php
    session_start();

    require_once 'class/connection.php';
    require_once 'class/album.php';
    require 'require/head.php';
?>

<body class="bg-violetwe">
    <?php
        require_once 'require/nav.php';
    ?>

    <main>
        <div>
            <h2>Listes des utilisateurs </h2>
            <?php
            $connection = new Connection();
            $users = $connection->GetUsers();

            foreach ($users as $user): ?>
                    <div class="flex lg: flex-row lg: gap-2 lg: items-center">
                        <div>
                            <img src="images/avatars/<?php echo $user['logo'];?>" alt="">
                        </div>
                        <h3><?= $user['username']?></h3>
                        <p><?= $user['age']?></p>
                        <p><?= $user['description']?></p>
                        <div>
                        <a href="profil.php?id=<?php echo $user['id']?>">Voir le compte</a>
                        </div>
                    </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>