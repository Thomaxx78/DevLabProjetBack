import { createApp } from 'vue'
import './style.css'
import App from './App.vue'

createApp(App).mount('#app')

import axios from 'axios';

// Récupérer les films populaires
function popularMovies() {
    axios.get('https://api.themoviedb.org/3/trending/all/week?api_key=e5be04ec7de9aff432b14905a60c0bb8')
        .then((response) => {
            let movies = response.data.results;
            movies.forEach(movie => {
            let parent = document.querySelector('.divParent');
            let film = document.createElement('div');
            film.innerHTML = `
                <div>
                    <a href="#" onclick="movieSelected('${movie.id}')">${movie.title}</a>
                    <button type="submit" class="button" onclick="movieSelected('${movie.id}')">Movie Details</button>
                </div>`
            parent.appendChild(film);
        })
})}

popularMovies();


let finderbouton = document.getElementById("finderButton")
let inputGetCategory = document.getElementById("inputGetCategory")

// Créer une liste déroulante avec les genres de films pour la recherche par catégorie
axios.get('https://api.themoviedb.org/3/genre/movie/list?api_key=e5be04ec7de9aff432b14905a60c0bb8')
.then((response) => {
    let genres = response.data.genres;
    console.log(genres);
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


