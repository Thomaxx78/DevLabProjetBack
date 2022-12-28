// import axios from 'axios';

const {
    host, hostname, href, origin, pathname, port, protocol, search
} = window.location

console.log(search.replace('?id=', ''))

let movieId = search.replace('?id=', '')

// Récupérer les détails d'un film
function movieDetails(id) {
    console.log('id');
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
                <div>
                    <h1>${title}</h1>
                    <img src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="Poster">
                    <p>${movie.overview}</p>
                    <p>Release date: ${movie.release_date}</p>
                    <p>Vote average: ${movie.vote_average}</p>
                    <p>Vote count: ${movie.vote_count}</p>
                    <p>Popularity: ${movie.popularity}</p>
                    <p>Original language: ${movie.original_language}</p>
                </div>`
            parent.appendChild(film);
        })
}

movieDetails(movieId);