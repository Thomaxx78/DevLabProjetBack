<?php
    session_start();
?>
<?php require 'require/head.php';?>

<body>
    <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'autorisé') {
            $verify = 1;
            // $connection = new Connection();
            // $albums = $connection->GetAlbums();
        }
        if($verify != 1){
            header('Location:login.php');
        }

        require_once 'require/nav.php';
    ?>

    <h1>Dashboard</h1>
    <?php echo $_SESSION['username'];?>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>
