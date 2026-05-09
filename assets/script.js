const gameRows = Array.from(document.querySelectorAll('.game-row'));
const resultCount = document.querySelector('#results-count');
const freetextFilterInput = document.querySelector('#freetext-filter');
const filterCheckboxes = Array.from(document.querySelectorAll('input[type="checkbox"][data-filter-type]'));
const freetextFilterQueryParameter = 'q';
const hiddenFilterClasses = [
    'hidden-by-freetext-filter',
    ...filterCheckboxes.map(checkbox => `hidden-by-${checkbox.getAttribute('data-filter-type')}-filter`)
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

function getCheckboxFilterType(checkbox) {
    return checkbox.getAttribute('data-filter-type');
}

function isEnabledFilterQueryParameter(queryParameterValue) {
    return queryParameterValue !== null
        && queryParameterValue !== '0'
        && queryParameterValue.toLowerCase() !== 'false';
}

function getFilterStateFromUrl() {
    const queryParameters = new URLSearchParams(window.location.search);
    const filterState = {
        freetext: queryParameters.get(freetextFilterQueryParameter) ?? ''
    };

    filterCheckboxes.forEach((checkbox) => {
        const filterType = getCheckboxFilterType(checkbox);
        if (filterType === null) {
            return;
        }

        filterState[filterType] = isEnabledFilterQueryParameter(queryParameters.get(filterType));
    });

    return filterState;
}

function getFilterStateFromUi() {
    const filterState = {
        freetext: freetextFilterInput?.value ?? ''
    };

    filterCheckboxes.forEach((checkbox) => {
        const filterType = getCheckboxFilterType(checkbox);
        if (filterType === null) {
            return;
        }

        filterState[filterType] = checkbox.checked;
    });

    return filterState;
}

function syncUrlWithFilterState() {
    const filterState = getFilterStateFromUi();
    const queryParameters = new URLSearchParams();
    const freetextFilterValue = filterState.freetext.trim();

    if (freetextFilterValue !== '') {
        queryParameters.set(freetextFilterQueryParameter, freetextFilterValue);
    }

    filterCheckboxes.forEach((checkbox) => {
        const filterType = getCheckboxFilterType(checkbox);
        if (filterType === null || filterState[filterType] !== true) {
            return;
        }

        queryParameters.set(filterType, '1');
    });

    const nextQueryString = queryParameters.toString();
    const nextUrl = `${window.location.pathname}${nextQueryString === '' ? '' : `?${nextQueryString}`}${window.location.hash}`;

    try {
        window.history.replaceState(window.history.state, '', nextUrl);
    } catch (error) {
        // Some browsers are stricter for local file URLs. Filtering still works without URL sync.
    }
}

function applyFilterState(filterState) {
    if (freetextFilterInput !== null) {
        freetextFilterInput.value = filterState.freetext ?? '';
    }

    filterCheckboxes.forEach((checkbox) => {
        const filterType = getCheckboxFilterType(checkbox);
        if (filterType === null) {
            return;
        }

        checkbox.checked = filterState[filterType] === true;
    });

    applyFilters();
}

function applyFilters() {
    const freetextFilterValue = (freetextFilterInput?.value ?? '').trim();

    if (freetextFilterValue === '') {
        showFreetextFilteredGames(false);
    } else {
        hideGamesByFreetextFilter(freetextFilterValue, false);
    }

    filterCheckboxes.forEach((checkbox) => {
        const filterType = getCheckboxFilterType(checkbox);
        if (filterType === null) {
            return;
        }

        checkbox.checked ? hideGamesByFilter(filterType, false) : showGamesByFilter(filterType, false);
    });

    updateResultsCount();
}

function hideGamesByFreetextFilter(filterValue, shouldUpdateResultsCount = true) {
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

    if (shouldUpdateResultsCount) {
        updateResultsCount();
    }
}

function showFreetextFilteredGames(shouldUpdateResultsCount = true) {
    gameRows.forEach((row) => {
        row.classList.remove('hidden-by-freetext-filter');
    });

    if (shouldUpdateResultsCount) {
        updateResultsCount();
    }
}

function showGamesByFilter(filterType, shouldUpdateResultsCount = true) {
    const filterClass = `hidden-by-${filterType}-filter`;
    gameRows.forEach((row) => {
        row.classList.remove(filterClass);
    });

    if (shouldUpdateResultsCount) {
        updateResultsCount();
    }
}

function hideGamesByFilter(filterType, shouldUpdateResultsCount = true) {
    const filterClass = `hidden-by-${filterType}-filter`;
    gameRows.forEach((row) => {
        const isHiddenByFilter = !row.hasAttribute(`data-game-is-${filterType}`);
        if (isHiddenByFilter) {
            row.classList.add(filterClass);
        }
    });

    if (shouldUpdateResultsCount) {
        updateResultsCount();
    }
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

if (freetextFilterInput !== null) {
    freetextFilterInput.addEventListener(
        'input',
        debounce(() => {
            applyFilters();
            syncUrlWithFilterState();
        }, 350)
    );
}

filterCheckboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', () => {
        applyFilters();
        syncUrlWithFilterState();
    });
});

window.addEventListener('popstate', () => {
    applyFilterState(getFilterStateFromUrl());
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

applyFilterState(getFilterStateFromUrl());
