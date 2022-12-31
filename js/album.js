function showMoviesByIDs(allMoviesId) {
    allMoviesId.forEach((id) => {
    axios .get('https://api.themoviedb.org/3/movie/' + id + '?api_key=e5be04ec7de9aff432b14905a60c0bb8')
        .then((response) => {
            let movie = response.data;
            let movieDiv = document.createElement('div');
            movieDiv.innerHTML = `
                <div class="relative hover:block w-40">
                    <img class="w-full" src="https://image.tmdb.org/t/p/w500${movie.poster_path}" alt="">
                    <h3 class="absolute inset-0 flex items-center justify-center font-bold text-black text-xl opacity-0 hover:bg-black hover:opacity-100 hover:bg-white/50 ">${movie.title}</h3>
                </div>
            `;
            document.querySelector('#divParentAlbum').appendChild(movieDiv);
        })
    })
}
