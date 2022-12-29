<?php
    session_start();

    require_once "class/connection.php";

    if (isset($_GET['id'])) {
        $connection = new Connection;
        $userId = $_GET['id'];
        $user = $connection->GetSingleUser($userId);
        $found = true;
    } else {
        $found = false;
    }
?>

<?php require 'require/head.php';?>
<body>
    <?php
        if (!isset($_SESSION['role']) && $_SESSION['role'] != 1) {
            header('Location:login.php');
        }
        
        require_once 'require/nav.php';
    ?>

    <div class="flex flex-row items-center">
        <img src="images/avatars/<?php echo $user[0]['logo']?>" alt="">
        <div class="flex flex-col">
            <h1><?= $user[0]['username']?></h1>
            <p><?= $user[0]['age']?> ans<p>
            <p>A propos : <?= $user[0]['description']?></p>
        </div>
    </div>
    
    <br>

    <?php
        require_once 'class/connection.php';
        require_once 'class/album.php';
        require_once 'class/user.php';
        $connection = new Connection();
        $albums = $connection->getAlbumFromID($userId);
    ?>
        <div>
            <h2>Ses albums</h2>
            <div>
				<?php foreach ($albums as $album):
                    if($album['privacy'] == "public"):?>
                        <p><?=$album['name']?></p>
                    <!-- <a href="album.php?id=<?=($album['id'])?>"></a> -->
				<?php  endif; endforeach; ?>
            </div>
        </div>


    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>
