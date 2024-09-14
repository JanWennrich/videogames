<?php

namespace Jan\GamesLibrary\Platform;

use Jan\GamesLibrary\Platform;

final class Steam implements Platform
{
    public function getIconPath(): string
    {
        return 'platform_icons/steam.png';
    }

    public function getName(): string
    {
        return 'Steam';
    }
}
