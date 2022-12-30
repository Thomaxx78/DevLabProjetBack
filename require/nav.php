	<nav class=" bg-darkgrey top-0 left-0 w-full px-4 py-4 flex justify-between items-center">
		<a href="index.php" class="lg:ml-8"><img src="public/logo.png" class="w-48 lg:w-48" alt="Logo de Mon Expert Propreté"></a>
		<div class="lg:hidden">
		<button class="navbar-burger flex items-center text-white p-3">
				<svg class="block h-8 w-8 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<title>Mobile menu</title>
					<path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
				</svg>
			</button>
		</div>
        <input type="text" class="hidden lg:block lg:w-2/12 lg:h-8 lg:rounded-lg lg:bg-white lg:p-2 ml-40 mr-auto" placeholder="Rechercher votre film">
		<ul class="hidden  lg:flex ">
            <?php 
            if (isset($_SESSION['username'])) { ?>
            <li> <a href="logout.php" class="hidden lg:block text-xl text-white mr-8 ml-auto border-2 rounded-lg border-white px-4 py-1 ">Déconnection</a></li>
			<li> <a href="dashboard.php" class="hidden lg:block text-xl text-white mr-8 ml-auto border-2 rounded-lg border-white px-4 py-1 ">Profil</a></li>
            <?php } 
            else { ?>
			<li> <a href="signin.php" class="hidden lg:block text-xl text-white mr-8 ml-auto border-2 rounded-lg border-white px-4 py-1 hover:text-black hover:bg-white">S'inscrire</a></li>
			<li><a href="login.php" class="hidden lg:block text-xl text-white mr-8 border-2 rounded-lg border-white px-2 py-1 hover:text-black hover:bg-white">Se connecter</a></li>
            <?php } ?>
		</ul>
	</nav>
	<div class="navbar-menu relative z-50 hidden">
		<div class="navbar-backdrop fixed inset-0 bg-gray-800 opacity-25"></div>
		<nav class="fixed top-0 left-0 bottom-0 flex flex-col w-5/6 max-w-sm pt-6 px-6 border-r border-white overflow-y-auto bg-darkgrey">
			<div class="flex items-center mb-8">
				<a href="index.php" class="w-8/12"><img src="public/logo.png" class="lg:h-12" alt="Logo de Delimovie"></a>
				<button class="navbar-close mr-0 ml-auto">
					<svg class="h-6 w-6 text-gray-400 cursor-pointer hover:text-gray-500 mt-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
					</svg>
				</button>
			</div>
			<div>
				<ul>
					<li class="mb-1">
						<a href="index.php" class="block p-4 text-2xl font-bold text-white">Accueil</a>
					</li>
				</ul>
			</div>
			<div class="mt-auto flex items-center mb-12">
			<li class="mb-1">
						<a class="text-xl text-white  border-2 rounded-lg border-white px-4 py-1 hover:text-black hover:bg-white" href="connexion.php">Connexion</a>
					</li>
					<li class="mb-1">
						<a class="text-xl text-white  border-2 rounded-lg border-white px-4 py-1 hover:text-black hover:bg-white" href="inscription.php">Inscription</a>
					</li>
			</div>
            <script src="js/burger.js"></script>
		</nav>
	</div>