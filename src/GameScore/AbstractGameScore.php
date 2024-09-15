<?php

namespace Jan\GamesLibrary\GameScore;

abstract class AbstractGameScore
{
    public function __construct(public int $value)
    {
    }
}
