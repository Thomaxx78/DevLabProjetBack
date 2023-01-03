// import '../output.css'

// import axios from 'axios';

// Récupérer les films populaires sur la premiere pages de tendances de la semaine (20 films)
function popularMovies() {
    axios.get('https://api.themoviedb.org/3/trending/all/week?api_key=e5be04ec7de9aff432b14905a60c0bb8')
        .then((response) => {
            let movies = response.data.results;
            movies.forEach(movie => {
            let parent = document.querySelector('.divParent');
            let film = document.createElement('div');
            showMovie(parent, film, movie)
        })
})}

popularMovies();

let inputGetCategory = document.getElementById("inputGetCategory")

let option = document.createElement('option');
option.innerHTML = "Ne pas trier";
option.value =  "No";
inputGetCategory.appendChild(option);
inputGetCategory.addEventListener("change", function(){
    document.querySelectorAll('.divParent > div').forEach(e => e.remove());
    popularMovies();
})
// Créer une liste avec les genres de films pour la recherche par catégorie
axios.get('https://api.themoviedb.org/3/genre/movie/list?api_key=e5be04ec7de9aff432b14905a60c0bb8')
.then((response) => {
    let genres = response.data.genres;
    genres.forEach(genre => {
        let option = document.createElement('option');
        option.innerHTML = genre.name;
        option.value =  genre.name;
        inputGetCategory.appendChild(option);
        // Récupérer l'id du genre de film sélectionné
        inputGetCategory.addEventListener("change", function(){
            axios.get('https://api.themoviedb.org/3/genre/movie/list?api_key=e5be04ec7de9aff432b14905a60c0bb8')
                .then((response) => {
                    let genres = response.data.genres;
                    genres.forEach(genre => {
                        if (genre.name == option.innerHTML) {
                            moviesByCategory(genre.id)
                        }
                    })
                })
            })
        })
    })

// Récupérer les films par catégorie les plus tendances de la semaine. Propose au moins 24 films dans la limite de 50 pages parcourues
function moviesByCategory(genreId) {
    document.querySelectorAll('.divParent > div').forEach(e => e.remove());
    for (let i = 1; i < 50; i++) {
        axios.get('https://api.themoviedb.org/3/trending/all/week?api_key=e5be04ec7de9aff432b14905a60c0bb8&page=' + i)
        .then((response) => {
            let movies = response.data.results;
            movies.forEach(movie => {
                let parent = document.querySelector('.divParent');
                let film = document.createElement('div');
                let movieNumber = document.querySelectorAll('.divParent > div').length;
                if(movieNumber < 24){
                    if(movie.genre_ids != undefined && movie.genre_ids.includes(genreId)){
                        showMovie(parent, film, movie)
                    }
                } else{
                    return
                }
            })
        })
    } 
}

// Afficher les films dans la page 
function showMovie(parent, film, movie){
    // Certain films n'ont pas d'attribut title, on utilise alors l'attribut name
    let title = "";
    if(movie.title == null){
        title = movie.name
    } else {
        title = movie.title
    }
    film.innerHTML = 
    `
        <img class="w-32" src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="Poster">
        <span class="text-center mt-1">${title}</span>
        <button class="detailsMovie text-darkgrey" value="${movie.id}">Voir les détails</button>
        <span class="hidden">${movie.vote_average}</span>
        <span class="hidden">${movie.popularity}</span>
    `
    parent.appendChild(film);
    film.classList.add("flex", "flex-col", "items-center", "rounded", "shadow", "m-2", "p-2", "w-64", "bg-white", "text-black", "hover:bg-gray-200", "hover:text-gray-800", "transition", "duration-500", "ease-in-out", "transform", "hover:-translate-y-1", "hover:scale-110");
    film.children[film.children.length-3].addEventListener('click', event => {
        window.location ="detail.php?id="+movie.id;
    })
}

let selectSort = document.querySelectorAll("#triMovies > span");
selectSort.forEach(select => {
    select.addEventListener('click', function() {
        switch (select.innerHTML) {
            case 'Note croissante':
                moviesByPopularity(3, "Up");
                break;
            case 'Note décroissante':
                moviesByPopularity(3, "Down");
                break;
            case 'Nom':
                moviesByName();
                break;
            case 'Avis imbd':
                moviesByPopularity(4, "Down");
                break;
            default:
                document.querySelectorAll('.divParent > div').forEach(e => e.remove());
                popularMovies();
                break;
        }
    })
})

function moviesByName(){
    let allMovies = document.querySelectorAll('.divParent > div');
    let allMovieTitles = [];
    let allMoviesDictionary = {};
    allMovies.forEach(movie => {
        allMovieTitles.push(movie.children[1].innerHTML);
        allMoviesDictionary[movie.children[1].innerHTML] = movie;
    })
    allMovieTitles.sort();
    document.querySelectorAll('.divParent > div').forEach(e => e.remove());
    allMovieTitles.forEach(title => {
        document.querySelector('.divParent').appendChild(allMoviesDictionary[title]);
    })
}

function moviesByPopularity(option, how){
    let allMovies = document.querySelectorAll('.divParent > div');
    let allMovieMarks = [];
    let allMoviesDictionary = {};
    let allMoviesDictionaryMark = {};
    allMovies.forEach(movie => {
        allMovieMarks.push(movie.children[option].innerHTML);
        allMoviesDictionaryMark[movie.children[option].innerHTML] = movie.children[1].innerHTML;
        allMoviesDictionary[movie.children[1].innerHTML] = movie;
    })
    allMovieMarks.sort();
        if(how == "Down"){
            allMovieMarks.reverse();
        }
    document.querySelectorAll('.divParent > div').forEach(e => e.remove());
    allMovieMarks.forEach(mark => {
        document.querySelector('.divParent').appendChild(allMoviesDictionary[allMoviesDictionaryMark[mark]]);
    })
}

// Chercher un film avec la barre de recherche
let search = document.querySelector("#searchBar");
search.addEventListener('keyup', function(){
    let searchValue = search.value;
    if(searchValue.length > 2){
        axios.get('https://api.themoviedb.org/3/search/movie?api_key=e5be04ec7de9aff432b14905a60c0bb8&page=1&query=' + searchValue)
        .then((response) => {
            let movies = response.data.results;
            document.querySelectorAll('.divParent > div').forEach(e => e.remove());
            movies.forEach(movie => {
                let parent = document.querySelector('.divParent');
                let film = document.createElement('div');
                showMovie(parent, film, movie)
            })
        })
    } else{
        document.querySelectorAll('.divParent > div').forEach(e => e.remove());
        popularMovies();
    }
})

