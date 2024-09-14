<?php

namespace Jan\GamesLibrary\Platform;

use Jan\GamesLibrary\Platform;

final class BattleNet implements Platform
{
    public function getIconPath(): string
    {
        return 'platform_icons/battle_net.png';
    }

    public function getName(): string
    {
        return 'Battle.net';
    }
}
