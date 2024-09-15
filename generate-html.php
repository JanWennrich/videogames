<?php

use Jan\GamesLibrary\GamesCsvParser;
use Jan\GamesLibrary\HtmlGenerator;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once "vendor/autoload.php";

$diContainer = new \DI\Container([
    Environment::class => \DI\factory(function () {
        return new Environment(new FilesystemLoader(__DIR__ . '/templates'));
    }),
]);

$csvParser = $diContainer->get(GamesCsvParser::class);

$games = $csvParser->parseGamesCsvFile(__DIR__ . '/resources/games.csv');

$html = $diContainer->get(HtmlGenerator::class)->generateHtml($games);

echo $html;
