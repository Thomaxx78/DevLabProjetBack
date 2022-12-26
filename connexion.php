<?php 
require 'require/head.php'
?>
<body class="w-full bg-violetwe">
    <header class="z-40 sticky w-full bg-darkgrey mt-0 mb-auto py-2">
        <?php require 'require/nav.php' ?>
    </header>
<div class="mt-16 w-3/12 h-auto bg-white ml-auto mr-auto text-center rounded-lg p-4 border-8 border-darkgrey">
    <p class="text-2xl text-darkgrey font-semibold">Se connecter</p>
    <form class="mt-8">
        <input type="email" name="email" placeholder="E-mail"><br>
        <input type="password" name="password1" placeholder="Password"><br>
        <input class="bg-darkgrey text-darkgrey mt-4 px-2 rounded-lg" type="submit" value="connexion" name="connect">
</form>
</div>
</body>