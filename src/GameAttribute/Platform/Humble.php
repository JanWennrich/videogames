<?php

namespace Jan\GamesLibrary\GameAttribute\Platform;

use Jan\GamesLibrary\GameAttribute\Platform;

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
