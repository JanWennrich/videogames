<?php

namespace Jan\GamesLibrary\Platform;

use Jan\GamesLibrary\Platform;

final class Ea implements Platform
{
    public function getIconPath(): string
    {
        return 'platform_icons/ea.png';
    }

    public function getName(): string
    {
        return 'EA Games (Origin)';
    }
}
