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
        <div class="lg:mx-24 bg-darkgrey p-8 mt-8 rounded-lg lg:w-auto w-10/12 m-auto">
            <h2 class="text-white text-2xl lg:text-3xl font-bold mb-16">Listes des utilisateurs: </h2>
            <div class="flex flex-wrap gap-12">
            <?php
            $connection = new Connection();
            $users = $connection->GetUsers();

            foreach ($users as $user): ?>
                    <div class="flex mt-6">
                        <div>
                            <img class="lg:w-28 lg:h-28 w-32 h-32 object-cover rounded-full shadow-xl" src="images/avatars/<?php echo $user['logo'];?>" alt="">
                        </div>
                        <div class="ml-8 m-auto">
                            <h3 class="text-2xl text-white font-bold"><?= $user['username']?></h3>
                            <a class="text-violetwe underline mb-0 mt-auto"href="profil.php?id=<?php echo $user['id']?>">Voir le compte</a>
                        </div>
                    </div>
            <?php endforeach; ?>
            </div>
        </div>
    </main>
</body>
</html>