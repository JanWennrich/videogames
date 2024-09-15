# Jan's Games Library 🎮📚

This is a static site generator for my (PC) games library.

It takes the CSV file `assets/games.csv` (exported from [Playnite](https://playnite.link/)), generates an HTML file (via PHP) and deploys it to GitHub pages.

## Usage

1. Run `composer install`
2. Run `make`
3. Open `build/index.html` in your browser

(The deployment to GitHub pages is handled by the GitHub action in `.github/workflows/pages.yml`)