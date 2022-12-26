<?php 
require 'require/head.php'
?>
<body>
    <header class="w-full bg-darkgrey mt-0 mb-auto py-2">
        <?php require 'require/nav.php' ?>
    </header>
    <div class="flex">
        <div class="h-full bg-semidarkgrey lg:w-96 lg:ml-0 lg:mr-auto lg:pt-8  ">
            <!--<div class="hidden lg:block">
                <h2 class=" text-white text-3xl text-center font-semibold">Découvrir:</h2>
                <p class="text-2xl text-white ml-8 lg:mt-4">Trier par:</p>
                <p class="lg:ml-16 text-lightgrey text-xl mt-2">Noms</p>
                <p class="lg:ml-16 text-lightgrey text-xl mt-2">Notes</p>
                <h3 class="text-2xl text-white ml-8 mt-16 lg:mt-8">Catégorie:</h3>
                <ul class="ml-16 grid grid-cols-3 text-lightgrey mt-4 text-xl">
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                    <li>Horreur</li>
                </ul>
                <a href="#" class="py-1 px-2 rounded-lg bg-white  text-semidarkgrey font-semibold text-xl ml-auto">Rechercher</a>
                <div>
                <script type="module" src="js/main.js"></script>
-->
                </div>
            </div>
        <div class="flex-col ml-4 lg:hidden">
            <h2 class="text-white text-2xl m-auto">Films tendances</h2>
        <div class="flex justify-between">
            <div>
                <span class="text-white text-xl">Trier par</span>
                <select name="triMovies" id="triMovies">
                    <option value="name">Nom</option>
                    <option value="mark">Note</option>
                </select>
            </div>
            <div>
                <select name="inputGetCategory" id="inputGetCategory"></select>
                <button id="finderButton">Rechercher</button>
            </div>
        </div>
        </div>
    </div>
    <!--
    <main>
        <h2 class="text-blue-700 m-auto">Films tendances</h2>
        <div class="flex justify-between">
            <div>
                <span>Trier par</span>
                <select name="triMovies" id="triMovies">
                    <option value="name">Nom</option>
                    <option value="mark">Note</option>
                </select>
            </div>
            <div>
                <select name="inputGetCategory" id="inputGetCategory"></select>
                <button id="finderButton">Rechercher</button>
            </div>
        </div>
        <div class="divParent flex flex-wrap justify-center gap-8"></div>
    </main>
-->
    <script type="module" src="js/main.js"></script>
</body>
</html>



