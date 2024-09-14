<?php

namespace Jan\GamesLibrary\Platform;

use Jan\GamesLibrary\Platform;

final class Humble implements Platform
{
    public function getIconPath(): string
    {
        return 'platform_icons/humble.png';
    }

    public function getName(): string
    {
        return 'Humble';
    }
}
