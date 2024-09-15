<?php

namespace Jan\GamesLibrary\GameAttribute;

final class Playtime
{
    private function __construct(private readonly int $playtimeInSeconds)
    {
    }

    public static function fromSeconds(int $playtimeInSeconds): self
    {
        return new self($playtimeInSeconds);
    }

    public function getInHours(): int
    {
        return intdiv($this->playtimeInSeconds, 3600);
    }
}
