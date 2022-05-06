let search = document.createElement('input');
search.type = 'text';
search.className = 'from-control';
search.placeholder = 'Search for a movie';
let select = document.getElementById('film_name');
insertBefore(search, select);

search.addEventListener('input', function(e) {
    const filmName = e.target.value;

    if (filmName) {
        fetch(`https://api.themoviedb.org/3/search/movie?api_key=90dad6e38e87d496f6fcdd14a7ba5163&query=${filmName}&language=fr`)
        .then(response => response.json())
        .then(data => {
            select.options.length = 0;
            data.results.map(film => {
                select.options[select.options.length] = new Option(film.title, film.id);
            });
        });
    }
});

function insertBefore(newNode, existingNode) {
    existingNode.parentNode.insertBefore(newNode, existingNode);
}