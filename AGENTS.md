# AGENTS.md

## Overview

This repository generates a static HTML page for a personal PC game library.

- Backend: PHP 8.2
- Templating: Twig
- Input data: `assets/games.csv`
- Generated output: `build/index.html`

The entry point is `generate-html.php`, which parses the CSV and renders `templates/page.twig`.

## Repository Layout

- `src/`: PHP domain code and HTML generation
- `templates/`: Twig templates for the page, filters, and game rows
- `assets/`: Source CSS, JS, fonts, CSV data, and platform icons
- `build/`: Generated site output; treat this as build artifact output
- `tests/`: Test namespace is configured, but there are currently no substantive tests

## Working Rules

- Do not edit `build/` as the source of truth. Update `src/`, `templates/`, or `assets/`, then rebuild.
- Preserve existing user changes in the worktree. This repository may be dirty.
- Keep frontend changes mobile-first. Narrow screens should be the default CSS baseline, with wider layouts added via `min-width` breakpoints.
- Prefer small, targeted template and stylesheet changes over broad rewrites.

## Common Commands

Install dependencies:

```bash
composer install
```

Build the static page:

```bash
make build-page
```

Run the full quality suite:

```bash
composer test
```

Run individual checks:

```bash
vendor/bin/phpstan
vendor/bin/phpunit
vendor/bin/phpcs
```

## Frontend Notes

- Main stylesheet: `assets/style.css`
- Main client behavior: `assets/script.js`
- Game row markup: `templates/game.twig`
- Filter markup: `templates/filter.twig`

The current responsive approach uses card-style stacked game rows on mobile and restores the table layout on larger screens.

## Backend Notes

- `src/GamesCsvParser.php` loads and maps CSV data into `Game` objects.
- `src/HtmlGenerator.php` sorts games by name and renders the Twig page.
- Platform-specific icon mapping lives under `src/GameAttribute/Platform/`.

## When Making Changes

1. Change source files in `src/`, `templates/`, or `assets/`.
2. Rebuild the site with `make build-page`.
3. Run relevant validation commands.
4. If the change affects layout, verify both mobile and desktop behavior.
