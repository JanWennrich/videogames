<?php

namespace Jan\GamesLibrary\Platform;

use Jan\GamesLibrary\Platform;

final class Gog implements Platform
{
    public function getIconPath(): string
    {
        return 'platform_icons/gog.png';
    }

    public function getName(): string
    {
        return 'GOG';
    }
}
