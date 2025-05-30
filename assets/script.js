function debounce(callback, wait) {
    let timeoutId = null;
    return (...args) => {
        window.clearTimeout(timeoutId);
        timeoutId = window.setTimeout(() => {
            callback(...args);
        }, wait);
    };
}

document.querySelector('#freetext-filter').addEventListener(
    'input',
    debounce(onFreetextFilterInputEvent, 350)
);

function onFreetextFilterInputEvent(event) {
    const freetextFilter = event.target.value;

    if (freetextFilter === '') {
        showFreetextFilteredGames();
        return;
    }

    hideGamesByFreetextFilter(event.target.value);
}

function hideGamesByFreetextFilter(filterValue) {
    function isFilterValueInFilterableGameColumn(gameRow) {
        const gameName = gameRow.querySelector('.game-column-name').textContent;
        const isFilterValueInGameName = gameName.toLowerCase().includes(filterValue.toLowerCase());
        if (isFilterValueInGameName) {
            return true;
        }
        const gamePlatform = gameRow.querySelector('.game-column-platform img').alt;
        const isFilterValueInGamePlatform = gamePlatform.toLowerCase().includes(filterValue.toLowerCase());
        if (isFilterValueInGamePlatform) {
            return true;
        }
        const gameGenres = Array.from(gameRow.querySelectorAll('.game-column-genres li')).map(genre => genre.textContent);
        const isFilterValueInGameGenres = gameGenres.some(genre => genre.toLowerCase().includes(filterValue.toLowerCase()));
        if (isFilterValueInGameGenres) {
            return true;
        }
        return false;
    }
    document.querySelectorAll('.game-row').forEach((row) => {
        if (isFilterValueInFilterableGameColumn(row)) {
            row.classList.remove('hidden-by-freetext-filter');
        } else {
            row.classList.add('hidden-by-freetext-filter');
        }
    })
}

function showFreetextFilteredGames() {
    document.querySelectorAll('.game-row').forEach((row) => {
        row.classList.remove('hidden-by-freetext-filter');
    })
}

function showGamesByFilter(filterType) {
    const filterClass = `hidden-by-${filterType}-filter`;
    document.querySelectorAll('.game-row').forEach((row) => {
        row.classList.remove(filterClass);
    });
}

function hideGamesByFilter(filterType) {
    const filterClass = `hidden-by-${filterType}-filter`;
    document.querySelectorAll('.game-row').forEach((row) => {
        const isHiddenByFilter = !row.hasAttribute(`data-game-is-${filterType}`);
        if (isHiddenByFilter) {
            row.classList.add(filterClass);
        }
    })
}

document.querySelectorAll('input[type="checkbox"][data-filter-type]').forEach((checkbox) => {
    checkbox.addEventListener(
        'change',
        event => {
            const filterType = event.target.getAttribute('data-filter-type');
            event.target.checked ? hideGamesByFilter(filterType) : showGamesByFilter(filterType)
        }
    )
})
