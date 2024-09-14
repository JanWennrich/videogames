<?php

namespace Jan\GamesLibrary;

use Twig\Environment;

final readonly class HtmlGenerator
{
    public function __construct(private Environment $twig)
    {
    }

    /**
     * @param Game[] $games
     */
    public function generateHtml(array $games): string
    {
        $this->sortGamesByName($games);

        $params = ['games' => $games];
        return $this->twig->render('page.twig', $params);
    }

    /**
     * @param Game[] $games
     */
    private function sortGamesByName(array &$games): void
    {
        usort($games, fn(Game $gameA, Game $gameB) => strcasecmp($gameA->name, $gameB->name));
    }
}
