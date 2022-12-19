import '../style.css'

import axios from 'axios';

// Récupérer les films populaires
function popularMovies() {
    axios.get('https://api.themoviedb.org/3/trending/all/week?api_key=e5be04ec7de9aff432b14905a60c0bb8')
        .then((response) => {
            let movies = response.data.results;
            movies.forEach(movie => {
            let parent = document.querySelector('.divParent');
            let film = document.createElement('div');
            film.innerHTML = 
                    // <img class="w-32" src="https://image.tmdb.org/t/p/w500/${movie.poster_path}" alt="Poster">
                    `
                    <span>${movie.title}</span>
                    <button class="detailsMovie" value="${movie.id}">Movie Details</button>
                    `
            parent.appendChild(film);
            film.children[1].addEventListener('click', event => {
                window.location ="detail.php?id="+movie.id;
            })
        })
})}

popularMovies();

let finderbouton = document.getElementById("finderButton")
let inputGetCategory = document.getElementById("inputGetCategory")

// Créer une liste déroulante avec les genres de films pour la recherche par catégorie
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
            // console.log(genres);
            genres.forEach(genre => {
                if (genre.name == inputGetCategory.value) {
                    console.log(genre.id);
                    moviesByCategory(genre.id)
                } else{
                    console.log("Genre not found");
                }
                })
        })
})

// Récupérer les films par catégorie
function moviesByCategory(genreId) {
    axios.get('https://api.themoviedb.org/3/trending/all/week?api_key=e5be04ec7de9aff432b14905a60c0bb8')
        .then((response) => {
            let movies = response.data.results;
            movies.forEach(movie => {
                if(movie.genre_ids.includes(genreId)){
                    console.log(movie.genre_ids);
                }
        })
})}