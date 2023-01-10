<?php
    session_start();
    require_once 'class/connection.php';
    $connection = new Connection();
?>
<?php require 'require/head.php';?>
<!DOCTYPE html>
<body class="">
    <header class="z-40 fixed w-full bg-darkgrey mt-0 mb-auto py-2 top-0">
        <?php require 'require/nav.php' ?>
    </header>
    <div class="flex flex-col lg:flex-col justify-end lg:gap-4 lg:justify-start lg:h-full fixed bg-semidarkgrey lg:w-64 w-screen pt-32 pb-4 top-0 z-10">
        <div class="">
            <h3 class="hidden lg:block text-white text-center font-semibold text-xl my-4">Trier par:</h3>
            <div id="triMovies" class="flex gap-4 flex-row lg:flex-col lg:mx-12 text-lightgrey overflow-x-auto overflow-y-hidden whitespace-nowrap">
                <span class="text-center border-2 border-black font-bold cursor-pointer px-2 py-1 bg-white  text-darkgrey rounded-lg ml-2 lg:m-0 hover:bg-gray-300">Ne pas trier</span>
                <span class="text-center border-2 border-black font-bold cursor-pointer px-2 py-1 bg-white  text-darkgrey rounded-lg ml-2 lg:m-0 hover:bg-gray-300">Nom</span>
                <span class="text-center border-2 border-black font-bold cursor-pointer px-2 py-1 bg-white  text-darkgrey rounded-lg ml-2 lg:m-0 hover:bg-gray-300">Note décroissante</span>
                <span class="text-center border-2 border-black font-bold cursor-pointer px-2 py-1 bg-white  text-darkgrey rounded-lg ml-2 lg:m-0 hover:bg-gray-300">Note croissante</span>
                <span class="text-center border-2 border-black font-bold cursor-pointer px-2 py-1 bg-white  text-darkgrey rounded-lg ml-2 lg:m-0 hover:bg-gray-300">Avis imbd</span>
            </div>
        </div>
        <div class="flex flex-row gap-4 lg:flex-col items-center justify-center my-4">
            <h3 class="text-2xl text-white">Catégorie :</h3>
            <select class="lg:my-4 lg:p-[2px] rounded-md" id="inputGetCategory">
            </select>
        </div>
        <?php
            if(isset($_SESSION['id'])){
        ?>
        <div class="flex flex-row lg:flex-col lg:p-4 lg:text-center gap-2 items-center justify-center">
            <h3 class="text-l text-white">Ne pas afficher les films visionnés</h3>
            <input type="checkbox" id="inputNotWatched" class="w-6 h-6 bg-gray-100 border-gray-300 rounded">
        </div>
        <?php } ?>
    </div>
    <div class="divParent flex flex-col items-center lg:flex-row lg:flex-wrap lg:justify-center gap-8 lg:ml-64 mt-64 lg:mt-40"></div>
    
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
    <script>
    <?php if(isset($_SESSION['id'])){?>
        let allMoviesWatched = <?php echo json_encode($connection->getAllMoviesAlreadyWatched($_SESSION['id'])); ?>;
        let hideWatched = document.querySelector("#inputNotWatched");
        hideWatched.addEventListener('change', function(){
            if(hideWatched.checked){
                document.querySelectorAll('.divParent > div').forEach(movie => {
                    if(allMoviesWatched.includes(parseInt(movie.children[2].value))){
                        movie.classList.add("hidden");
                    }
                })
            }  else {
                document.querySelectorAll('.divParent > div').forEach(movie => {
                    if(allMoviesWatched.includes(parseInt(movie.children[2].value))){
                        movie.classList.remove("hidden");
                    }
                })
            }
        })
    <?php } ?>
    </script>
</body>
</html>



