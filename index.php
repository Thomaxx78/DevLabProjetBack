<?php require 'require/head.php';?>
<!DOCTYPE html>
<body>
    <header class="z-40 sticky w-full bg-darkgrey mt-0 mb-auto py-2">
        <?php require 'require/nav.php' ?>
    </header>
    <div class="hidden lg:flex">
        <div class="hidden lg:grid h-full fixed bg-semidarkgrey lg:w-96 lg:ml-0 lg:mr-auto lg:pt-28 bottom-0 ">
            <h2 class="text-white text-2xl text-center font-semibold mx-auto row-span-1 mt-4">Découvrir:</h2>
            <div>
                <h3 class="text-2xl text-white ml-8 mt-4">Trier par</h3>
                <div id="triMovies" class="flex flex-col">
                    <span class="cursor-pointer">Ne pas trier</span>
                    <span class="cursor-pointer">Nom</span>
                    <span class="cursor-pointer">Note décroissante</span>
                    <span class="cursor-pointer">Note croissante</span>
                    <span class="cursor-pointer">Avis imbd</span>
                </div>
            </div>
            <div>
                <h3 class="text-2xl text-white ml-8 mt-4">Catégorie:</h3>
                <select name="inputGetCategory" id="inputGetCategory"></select>
                <button id="finderButton" class="h-10 py-1 px-2 rounded-lg bg-white text-semidarkgrey font-semibold text-xl mx-auto mt-4">Rechercher</button>
            </div>
        </div>
    </div>
    <div class="divParent flex flex-wrap justify-center gap-8 ml-96"></div>

    <script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
    <script type="module" src="js/main.js"></script>
</body>
</html>



