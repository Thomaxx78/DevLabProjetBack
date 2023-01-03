<?php
    session_start();
?>
<?php require 'require/head.php';?>
<!DOCTYPE html>
<body class="">
    <header class="z-40 fixed w-full bg-darkgrey mt-0 mb-auto py-2 top-0">
        <?php require 'require/nav.php' ?>
    </header>
    <div class="flex flex-col-reverse lg:flex-col justify-end lg:justify-start lg:h-full fixed bg-semidarkgrey lg:w-64 w-screen pt-32 top-0 z-10">
        <div class="">
            <h3 class="hidden lg:block text-white text-center font-semibold text-2xl my-4">Trier par:</h3>
            <div id="triMovies" class="flex gap-4 flex-row lg:flex-col lg:mx-12 text-lightgrey overflow-x-auto overflow-y-hidden whitespace-nowrap">
                <span class="text-black cursor-pointer px-2 py-1 bg-zinc-500 rounded-lg ml-2 lg:m-0">Ne pas trier</span>
                <span class="text-black cursor-pointer px-2 py-1 bg-zinc-500 rounded-lg ">Nom</span>
                <span class="text-black cursor-pointer px-2 py-1 bg-zinc-500 rounded-lg ">Note décroissante</span>
                <span class="text-black cursor-pointer px-2 py-1 bg-zinc-500 rounded-lg ">Note croissante</span>
                <span class="text-black cursor-pointer px-2 py-1 bg-zinc-500 rounded-lg mr-2 lg:m-0">Avis imbd</span>
            </div>
        </div>
        <div class="flex flex-row lg:flex-col items-center justify-around my-4">
            <h3 class="text-2xl text-white">Catégorie:</h3>
            <select class="lg:my-4" id="inputGetCategory">
            </select>
        </div>
    </div>
    <div class="divParent flex flex-col items-center lg:flex-row lg:flex-wrap lg:justify-center gap-8 lg:ml-64 mt-64 lg:mt-40"></div>
    
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>



