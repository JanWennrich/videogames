const gameRows = Array.from(document.querySelectorAll('.game-row'));
const resultCount = document.querySelector('#results-count');
const hiddenFilterClasses = [
    'hidden-by-freetext-filter',
    'hidden-by-installed-filter',
    'hidden-by-couch-coop-filter',
    'hidden-by-favorite-filter'
];

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
        const gameGenres = Array.from(
            gameRow.querySelectorAll('.game-column-genres .genre-tag:not(.genre-tag-overflow)')
        ).map(genre => genre.textContent);
        const isFilterValueInGameGenres = gameGenres.some(genre => genre.toLowerCase().includes(filterValue.toLowerCase()));
        if (isFilterValueInGameGenres) {
            return true;
        }
        return false;
    }
    gameRows.forEach((row) => {
        if (isFilterValueInFilterableGameColumn(row)) {
            row.classList.remove('hidden-by-freetext-filter');
        } else {
            row.classList.add('hidden-by-freetext-filter');
        }
    });

    updateResultsCount();
}

function showFreetextFilteredGames() {
    gameRows.forEach((row) => {
        row.classList.remove('hidden-by-freetext-filter');
    });

    updateResultsCount();
}

function showGamesByFilter(filterType) {
    const filterClass = `hidden-by-${filterType}-filter`;
    gameRows.forEach((row) => {
        row.classList.remove(filterClass);
    });

    updateResultsCount();
}

function hideGamesByFilter(filterType) {
    const filterClass = `hidden-by-${filterType}-filter`;
    gameRows.forEach((row) => {
        const isHiddenByFilter = !row.hasAttribute(`data-game-is-${filterType}`);
        if (isHiddenByFilter) {
            row.classList.add(filterClass);
        }
    });

    updateResultsCount();
}

function updateResultsCount() {
    if (resultCount === null) {
        return;
    }

    const visibleRows = gameRows.filter(
        row => !hiddenFilterClasses.some(hiddenClass => row.classList.contains(hiddenClass))
    );

    resultCount.textContent = String(visibleRows.length);
}

document.querySelectorAll('input[type="checkbox"][data-filter-type]').forEach((checkbox) => {
    checkbox.addEventListener(
        'change',
        event => {
            const filterType = event.target.getAttribute('data-filter-type');
            event.target.checked ? hideGamesByFilter(filterType) : showGamesByFilter(filterType)
        }
    )
});

document.querySelectorAll('.genre-tag-toggle').forEach((toggle) => {
    toggle.addEventListener('click', () => {
        const genreList = toggle.closest('.genre-tags');

        if (genreList === null) {
            return;
        }

        const isExpanded = genreList.classList.toggle('genre-tags-expanded');
        toggle.setAttribute('aria-expanded', String(isExpanded));
        toggle.textContent = isExpanded
            ? toggle.getAttribute('data-expanded-label')
            : toggle.getAttribute('data-collapsed-label');
    });
});

updateResultsCount();
