<?php
    session_start();

    require_once 'class/connection.php';
    require_once 'class/album.php';
    require 'require/head.php';
?>

<body class="">
    <header class="z-40 fixed w-full bg-darkgrey mt-0 mb-auto py-2 top-0">
        <?php require 'require/nav.php' ?>
    </header>
    <main>

        <div class="divParent flex m-8 mt-40 lg:flex-row lg:mx-16 rounded-lg shadow-lg border-2 ">
            <div class="divParentContent m-8">
                <div class="flex gap-4 items-center">
                    <h2 class="font-semibold ">Ajouter le film à un de vos albums:</h2>
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                        <select name="albumChoice" id="albumChoice">
                            <?php 
                                $connection = new Connection();
                                $albums = $connection->getAlbumFromID($_SESSION['id']);
                                var_dump($albums);
                                foreach($albums as $album){
                                    echo '<option value="' . $album['id'] . '">' . $album['name'] . '</option>';
                                }
                            ?>
                        </select>
                        <input class="border border-black rounded-lg py-0.5 px-1.5 ml-2" type="submit" value="Ajouter">
                    </form>
                    <?php

                        if(isset($_POST['albumChoice'])){
                            $connection = new Connection();
                            $connection->verifyMovie($_GET['id']);
                            $connection->addMovieToAlbum($_GET['id'], $_POST['albumChoice']);
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="flex ml-16 mt-4 gap-4">
            <a href="index.php" class="rounded-lg border border-black px-3 py-1">Revenir au menu</a>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
        <script type="module" src="js/takeDetails.js"></script>
    </main>
</body>
</html>