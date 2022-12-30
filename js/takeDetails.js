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
            let parent = document.querySelector('.divParentContent');
            let film = document.createElement('div');
            let parentImage = document.querySelector('.divParent');
            let image = document.createElement('img');
            let title = "";
            if(movie.title == null){
                title = movie.name
            } else {
                title = movie.title
            }
            film.innerHTML = `
                <div class="divParentContent flex flex-col gap-2">
                    <h1 class='text-xl font-bold'>${title}</h1>
                    <span><span class="font-semibold">Release date:</span> ${movie.release_date}</span>
                    <span><span class="font-semibold">Vote average:</span> ${movie.vote_average}</span>
                    <span><span class="font-semibold">Vote count:</span> ${movie.vote_count}</span>
                    <span><span class="font-semibold">Popularity:</span> ${movie.popularity}</span>
                    <span><span class="font-semibold">Original language:</span> ${movie.original_language}</span>
                    <p class="mt-4"><p class="font-semibold">The description:<br></p>${movie.overview}</p>
                </div>
                        `
            parent.prepend(film);
            image.src = `https://image.tmdb.org/t/p/w500/${movie.poster_path}`
            image.classList = `h-96 rounded-l-lg`
            image.alt = `Image of ${movie.title}`
            parentImage.prepend(image);
        })
}

movieDetails(movieId);