<?php

namespace Jan\GamesLibrary;

use DateInterval;
use DateTimeImmutable;
use Jan\GamesLibrary\Platform\AbstractPlatform;

final readonly class Game
{
    public function __construct(
        public string $name,
        public Platform $platform,
        public int $playtimeInSeconds,
        public bool $isInstalled
    ) {
    }

    public function getPlaytimeInHours(): int
    {
        return intdiv($this->playtimeInSeconds, 3600);
    }
}
