<?php

namespace Jan\GamesLibrary\Platform;

use Jan\GamesLibrary\Platform;

final class Xbox implements Platform
{
    public function getIconPath(): string
    {
        return 'platform_icons/xbox.png';
    }

    public function getName(): string
    {
        return 'Xbox';
    }
}
