<?php

namespace Jan\GamesLibrary;

use Jan\GamesLibrary\Platform\AbstractPlatform;

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

        fgetcsv(stream: $gamesCsvFileHandle); // Skip first line containing column names
        while (($gameRecord = fgetcsv(stream: $gamesCsvFileHandle, separator: ",", enclosure: '"')) !== false) {
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
                playtimeInSeconds: $this->getPlayTimeFromGameRecord($gameRecord),
                isInstalled: $this->getInstallationStatusFromGameRecord($gameRecord),
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
    public function getPlayTimeFromGameRecord(array $gameRecord): int
    {
        return intval($gameRecord[26] ?? 0);
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
}
