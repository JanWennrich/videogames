<?php

namespace Jan\GamesLibrary\GameAttribute\Platform;

use Jan\GamesLibrary\GameAttribute\Platform;

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
