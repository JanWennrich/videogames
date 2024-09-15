<?php

namespace Jan\GamesLibrary\GameAttribute\Platform;

use Jan\GamesLibrary\GameAttribute\Platform;

final class Ubisoft implements Platform
{
    public function getIconPath(): string
    {
        return 'platform_icons/ubisoft.png';
    }

    public function getName(): string
    {
        return 'Ubisoft';
    }
}
