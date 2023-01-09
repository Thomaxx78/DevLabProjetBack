// import axios from 'axios';

const {
    host, hostname, href, origin, pathname, port, protocol, search
} = window.location

console.log(search.replace('?id=', ''))

let movieId = search.replace('?id=', '')

// Récupérer les détails d'un film
function movieDetails(id) {
    // console.log('id');
    axios .get('https://api.themoviedb.org/3/movie/' + id + '?api_key=e5be04ec7de9aff432b14905a60c0bb8')
        .then((response) => {
            let movie = response.data;
            console.log(movie);
            let parent = document.querySelector('main');
            let film = document.createElement('div');
            let title = "";
            if(movie.title == null){
                title = movie.name
            } else {
                title = movie.title
            }
            film.innerHTML = `
                <div class="flex flex-col m-8 lg:flex-row lg:mx-16 lg:my-4 rounded-lg shadow-lg border-2 mb-8">
                    <img class="h-96 rounded-t-lg lg:rounded-r-none lg:rounded-l-lg" src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="Poster">
                    <div class="flex flex-col m-8 gap-2">
                        <h1 class='text-xl font-bold'>${title}</h1>
                        <span><span class="font-semibold">Release date:</span> ${movie.release_date}</span>
                        <span><span class="font-semibold">Vote average:</span> ${movie.vote_average}</span>
                        <span><span class="font-semibold">Vote count:</span> ${movie.vote_count}</span>
                        <span><span class="font-semibold">Popularity:</span> ${movie.popularity}</span>
                        <span><span class="font-semibold">Original language:</span> ${movie.original_language}</span>
                        <p class="mt-4"><p class="font-semibold">The description:<br></p>${movie.overview}</p>
                    </div>
                </div>
                
                <a href="index.php" class="rounded-lg border border-black px-3 py-1 ml-8 lg:ml-16 lg:mt-8 hover:bg-black hover:text-white">Revenir à l'accueil</a>`
            parent.appendChild(film);
        })
}

movieDetails(movieId);