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

// Créer une liste déroulante avec les genres de films pour la recherche par catégorie
let option = document.createElement('option');
option.innerHTML = "Ne pas trier"
option.value = null;
inputGetCategory.appendChild(option);
axios.get('https://api.themoviedb.org/3/genre/movie/list?api_key=e5be04ec7de9aff432b14905a60c0bb8')
.then((response) => {
    let genres = response.data.genres;
    genres.forEach(genre => {
        let option = document.createElement('option');
        option.innerHTML = genre.name;
        option.value = genre.name;
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

// Récupérer les films par catégorie sur les 10 premieres pages de tendances de la semaine 
function moviesByCategory(genreId) {
    document.querySelectorAll('.divParent > div').forEach(e => e.remove());
    for (let i = 0; i < 10; i++) {
        axios.get('https://api.themoviedb.org/3/trending/all/week?api_key=e5be04ec7de9aff432b14905a60c0bb8&page=' + i)
        .then((response) => {
            let movies = response.data.results;
            movies.forEach(movie => {
                let parent = document.querySelector('.divParent');
                let film = document.createElement('div');
                if(movie.genre_ids.includes(genreId)){
                    showMovie(parent, film, movie)
                }
        })
    })
}}

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
    `
    parent.appendChild(film);
    film.classList.add("flex", "flex-col", "items-center", "rounded", "shadow", "m-2", "p-2", "w-64", "bg-white", "text-black", "hover:bg-gray-200", "hover:text-gray-800", "transition", "duration-500", "ease-in-out", "transform", "hover:-translate-y-1", "hover:scale-110");
    film.children[film.children.length-1].addEventListener('click', event => {
        window.location ="detail.php?id="+movie.id;
    })
}

let selectSort = document.getElementById("triMovies");
selectSort.addEventListener('change', function() {
    if(selectSort.value == "markUp"){
        moviesByPopularity("Up");
    } else if(selectSort.value == "markDown"){
        moviesByPopularity("Down");
    } else if(selectSort.value == "name"){
        moviesByName();
    } else if(selectSort.value == "noSort"){
        document.querySelectorAll('.divParent > div').forEach(e => e.remove());
        popularMovies();
    }
})


// Trier les films par nom
// function moviesByName() {
//     axios.get('https://api.themoviedb.org/3/trending/all/week?api_key=e5be04ec7de9aff432b14905a60c0bb8')
//     .then((response) => {
//         let movies = response.data.results;
//         let allMovieTitles = [];
//         let title = "";
//         movies.forEach(movie => {
//             if(movie.title == null){
//                 title = movie.name
//             } else {
//                 title = movie.title
//             }
//             allMovieTitles.push(title);
//         })
//         allMovieTitles.sort();
//         document.querySelectorAll('.divParent > div').forEach(e => e.remove());
//         showMoviesSort(allMovieTitles, movies, "title")
//     })
// }


// function moviesByPopularity(how){
//     axios.get('https://api.themoviedb.org/3/trending/all/week?api_key=e5be04ec7de9aff432b14905a60c0bb8')
//     .then((response) => {
//         let movies = response.data.results;
//         let allMovieMark = [];
//         movies.forEach(movie => {
//             allMovieMark.push(movie.vote_average);
//         })
//         allMovieMark.sort();
//         if(how == "Down"){
//             allMovieMark.reverse();
//         }
//         // console.log(allMovieMark)
//         document.querySelectorAll('.divParent > div').forEach(e => e.remove());
//         showMoviesSort(allMovieMark, movies, "mark")
//     })
// }

// // Ajouter les films dans l'ordre (Pas optimisé mais fonctionnel)
// function showMoviesSort(array, movies, element){
//     array.forEach(MovieOrder => {
//         movies.forEach(movie => {
//             let parent = document.querySelector('.divParent');
//             let film = document.createElement('div');
//             let title = "";
//             if(movie.title == null){
//                 title = movie.name
//             } else {
//                 title = movie.title
//             }
//             if(element == "mark"){
//                 if(MovieOrder == movie.vote_average){
//                     showMovie(parent, film, movie)
//                 }
//             } else {
//                 if(title == MovieOrder){
//                     showMovie(parent, film, movie)
//                 }
//             }
//         })
//     })
// }


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

function moviesByPopularity(how){
    let allMovies = document.querySelectorAll('.divParent > div');
    let allMovieMarks = [];
    let allMoviesDictionary = {};
    let allMoviesDictionaryMark = {};
    allMovies.forEach(movie => {
        allMovieMarks.push(movie.children[3].innerHTML);
        allMoviesDictionaryMark[movie.children[3].innerHTML] = movie.children[1].innerHTML;
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