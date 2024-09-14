<?php

namespace Jan\GamesLibrary\Platform;

use Jan\GamesLibrary\Platform;

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
