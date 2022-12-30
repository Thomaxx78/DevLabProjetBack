<?php
    session_start();
?>
<?php require 'require/head.php';?>
<!DOCTYPE html>
<body>
    <header class="z-40 fixed w-full bg-darkgrey mt-0 mb-auto py-2 top-0">
        <?php require 'require/nav.php' ?>
    </header>
    <div class="hidden lg:flex"> <!-- Version Ordinateur -->
        <div class="hidden lg:grid h-full fixed bg-semidarkgrey lg:w-96 lg:ml-0 lg:mr-auto lg:pt-28 bottom-0 lg:grid-rows-[10%_20%_45%]">
            <h2 class="text-white text-3xl text-center font-semibold mx-auto row-span-1 mt-6 2xl:text-4xl">Découvrir:</h2>
            <div class="grid-span-2">
                <h3 class="text-2xl text-white ml-4 2xl:text-3xl 2xl:mt-4">Trier par:</h3>
                <div id="triMovies" class="grid grid-cols-2 ml-8 mt-2 text-lightgrey 2xl:text-xl 2xl:gap-2">
                    <span class="cursor-pointer">Ne pas trier</span>
                    <span class="cursor-pointer">Nom</span>
                    <span class="cursor-pointer">Note décroissante</span>
                    <span class="cursor-pointer">Note croissante</span>
                    <span class="cursor-pointer">Avis imbd</span>
                </div>
            </div>
            <div class="w-96 grid-span-3">
                <h3 class="text-2xl text-white ml-4 mt-4 2xl:text-3xl 2xl:mt-8">Catégorie:</h3>
                <div class="grid grid-cols-2 w-full ml-8 mt-2 text-lightgrey xl:gap-1 2xl:text-xl 2xl:gap-2" name="inputGetCategory" id="inputGetCategory"></div>
            </div>
        </div>
    </div>
    <div class="lg:hidden h-32 lg:bg-semidarkgrey mt-28 pt-4">
        <h3 class="text-2xl text-white">Trier Version Téléphone</h3>
    </div>
    <div class="divParent flex flex-wrap justify-center gap-8 ml-96 mt-40"></div>
    
    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>



