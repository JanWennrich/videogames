<?php

namespace Jan\GamesLibrary;

use Jan\GamesLibrary\GameAttribute\Feature;
use Jan\GamesLibrary\GameAttribute\Genre;
use Jan\GamesLibrary\GameAttribute\Score\CommunityScore;
use Jan\GamesLibrary\GameAttribute\Score\CriticScore;
use Jan\GamesLibrary\GameAttribute\Platform;
use Jan\GamesLibrary\GameAttribute\PlatformFactory;
use Jan\GamesLibrary\GameAttribute\Playtime;

/**
 * @template GameRecord of string[]
 */
final readonly class GamesCsvParser
{
    public function __construct(private PlatformFactory $platformFactory)
    {
    }

    /**
     * @return Game[]
     */
    public function parseGamesCsvFile(string $pathToGamesCsvFile): array
    {
        $gamesCsvFileHandle = fopen($pathToGamesCsvFile, "r");

        if ($gamesCsvFileHandle === false) {
            throw new \Exception("Unable to open csv file '$pathToGamesCsvFile'");
        }

        $games = [];

        fgetcsv(stream: $gamesCsvFileHandle, separator: ",", enclosure: '"', escape: "\\"); // Skip first line containing column names
        while (($gameRecord = fgetcsv(stream: $gamesCsvFileHandle, separator: ",", enclosure: '"', escape: "\\")) !== false) {
            /** @var GameRecord $gameRecord */
            if ($this->isGameRecordHidden($gameRecord)) {
                continue;
            }

            $gameName = $this->getNameFromGameRecord($gameRecord);

            if ($gameName === '') {
                continue;
            }

            $games[] = new Game(
                name: $gameName,
                platform: $this->getPlatformFromGameRecord($gameRecord),
                playtime: $this->getPlayTimeFromGameRecord($gameRecord),
                isInstalled: $this->getInstallationStatusFromGameRecord($gameRecord),
                description: $this->getDescriptionFromGameRecord($gameRecord),
                isFavorite: $this->isFavoriteGameRecord($gameRecord),
                features: $this->getFeaturesFromGameRecord($gameRecord),
                genres: $this->getGenresFromGameRecord($gameRecord),
                communityScore: $this->getCommunityScoreFromGameRecord($gameRecord),
                criticScore: $this->getCriticScoreFromGameRecord($gameRecord),
            );
        }
        fclose($gamesCsvFileHandle);

        return $games;
    }

    /**
     * @param GameRecord $gameRecord
     */
    private function getNameFromGameRecord(array $gameRecord): string
    {
            return $gameRecord[0] ?? '';
    }

    /**
     * @param GameRecord $gameRecord
     */
    public function getPlatformFromGameRecord(array $gameRecord): Platform
    {
        return $this->platformFactory->getPlatformByName($gameRecord[28]);
    }

    /**
     * @param GameRecord $gameRecord
     */
    public function getPlayTimeFromGameRecord(array $gameRecord): Playtime
    {
        $playtime = intval($gameRecord[26] ?? 0);

        return Playtime::fromSeconds($playtime);
    }

    /**
     * @param GameRecord $gameRecord
     */
    public function getInstallationStatusFromGameRecord(array $gameRecord): bool
    {
        return $gameRecord[13] === "True";
    }

    /**
     * @param GameRecord $gameRecord
     */
    public function isGameRecordHidden(array $gameRecord): bool
    {
        return $gameRecord[8] === "True";
    }

    /**
     * @param GameRecord $gameRecord
     */
    public function getDescriptionFromGameRecord(array $gameRecord): string
    {
        return $gameRecord[4] ?? '';
    }

    /**
     * @param GameRecord $gameRecord
     */
    private function isFavoriteGameRecord(array $gameRecord): bool
    {
        return $gameRecord[7] === "True";
    }

    /**
     * @param GameRecord $gameRecord
     *
     * @return Feature[]
     */
    private function getFeaturesFromGameRecord(array $gameRecord): array
    {
        $featuresString = $gameRecord[9] ?? '';

        if ($featuresString === '') {
            return [];
        }

        $features = explode(', ', $featuresString);

        return array_map(fn(string $feature) => new Feature($feature), $features);
    }

    /**
     * @param GameRecord $gameRecord
     *
     * @return Genre[]
     */
    private function getGenresFromGameRecord(array $gameRecord): array
    {
        $genresString = $gameRecord[11] ?? '';

        if ($genresString === '') {
            return [];
        }

        $genres = explode(', ', $genresString);

        return array_map(fn(string $genre) => new Genre($genre), $genres);
    }

    /**
     * @param GameRecord $gameRecord
     */
    private function getCommunityScoreFromGameRecord(array $gameRecord): CommunityScore
    {
        $score = intval($gameRecord[32] ?? 0);

        return new CommunityScore($score);
    }

    /**
     * @param GameRecord $gameRecord
     */
    private function getCriticScoreFromGameRecord(array $gameRecord): CriticScore
    {
        $score = intval($gameRecord[33] ?? 0);

        return new CriticScore($score);
    }
}
