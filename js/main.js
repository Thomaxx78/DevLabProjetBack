import '../style.css'

import axios from 'axios';

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

let finderbouton = document.getElementById("finderButton")
let inputGetCategory = document.getElementById("inputGetCategory")

let option = document.createElement('option');
option.innerHTML = "Ne pas trier";
option.value =  "No";
inputGetCategory.appendChild(option);
// Créer une liste déroulante avec les genres de films pour la recherche par catégorie
axios.get('https://api.themoviedb.org/3/genre/movie/list?api_key=e5be04ec7de9aff432b14905a60c0bb8')
.then((response) => {
    let genres = response.data.genres;
    genres.forEach(genre => {
        let option = document.createElement('option');
        option.innerHTML = genre.name;
        option.value =  genre.name;
        inputGetCategory.appendChild(option);
    })
})

// Récupérer l'id du genre de film sélectionné
finderbouton.addEventListener("click", function(){
    axios.get('https://api.themoviedb.org/3/genre/movie/list?api_key=e5be04ec7de9aff432b14905a60c0bb8')
        .then((response) => {
            let genres = response.data.genres;
            genres.forEach(genre => {
                if (genre.name == inputGetCategory.value) {
                    moviesByCategory(genre.id)
                } else{
                    console.log("Genre not found");
                }
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
    <span class="text-center">${title}</span>
    <button class="detailsMovie text-white" value="${movie.id}">Movie Details</button>
    <span class="hidden">${movie.vote_average}</span>
    <span class="hidden">${movie.popularity}</span>
    `
    parent.appendChild(film);
    film.classList.add("flex", "flex-col", "items-center", "rounded", "shadow", "m-2", "p-2", "w-64", "bg-white", "text-black", "hover:bg-gray-200", "hover:text-gray-800", "transition", "duration-500", "ease-in-out", "transform", "hover:-translate-y-1", "hover:scale-110");
    film.children[film.children.length-3].addEventListener('click', event => {
        window.location ="detail.php?id="+movie.id;
    })
}

let selectSort = document.getElementById("triMovies");
selectSort.addEventListener('change', function() {
    if(selectSort.value == "markUp"){
        moviesByPopularity(3, "Up");
    } else if(selectSort.value == "markDown"){
        moviesByPopularity(3, "Down");
    } else if(selectSort.value == "name"){
        moviesByName();
    } else if(selectSort.value == "review"){
        moviesByPopularity(4, "Down");
    } else if(selectSort.value == "noSort"){
        document.querySelectorAll('.divParent > div').forEach(e => e.remove());
        popularMovies();
    }
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