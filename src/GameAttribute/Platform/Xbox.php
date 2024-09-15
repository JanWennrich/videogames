<?php

namespace Jan\GamesLibrary\GameAttribute\Platform;

use Jan\GamesLibrary\GameAttribute\Platform;

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
