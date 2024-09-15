<?php

namespace Jan\GamesLibrary\GameAttribute\Score;

abstract class AbstractScore
{
    public function __construct(public int $value)
    {
    }
}
