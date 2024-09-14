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

        $this->removeDuplicateGames($games);

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

    /**
     * @param Game[] $games
     */
    private function removeDuplicateGames(array &$games): void
    {
        $games = array_values(array_reduce($games, function (array $result, Game $game) {
            $normalizedGameName = $this->getNormalizedGameName($game);

            if (!isset($result[$normalizedGameName])) {
                $result[$normalizedGameName] = $game;
            }

            return $result;
        }, []));
    }

    private function getNormalizedGameName(Game $game): string
    {
        $normalizedGameName = $game->name;
        $normalizedGameName = htmlspecialchars_decode($normalizedGameName);
        $normalizedGameName = mb_strtolower($normalizedGameName);
        $normalizedGameName = str_ireplace(
            [
                'goty',
                'game of the year',
                'legacy edition',
                'enhanced edition',
                'complete edition',
                'techbeta',
                '(beta)',
                'beta',
                'enhanced edition'
            ],
            '',
            $normalizedGameName,
        );

        $normalizedGameNameWithOnlyAlphanumericCharacters = preg_replace('/[^a-z0-9]/i', '', $normalizedGameName);

        // Regex may return "null" on errors, so we only use the result if it's not "null"
        if ($normalizedGameNameWithOnlyAlphanumericCharacters !== null) {
            $normalizedGameName = $normalizedGameNameWithOnlyAlphanumericCharacters;
        }

        $normalizedGameName = str_replace(' ', '', $normalizedGameName);

        $normalizedGameName = trim($normalizedGameName);
        return $normalizedGameName;
    }
}
