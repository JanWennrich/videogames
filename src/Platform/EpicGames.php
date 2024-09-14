<?php

namespace Jan\GamesLibrary\Platform;

use Jan\GamesLibrary\Platform;

final class EpicGames implements Platform
{
    public function getIconPath(): string
    {
        return 'platform_icons/epic_games.png';
    }

    public function getName(): string
    {
        return 'Epic Games';
    }
}
