<?php

namespace Jan\GamesLibrary;

use Jan\GamesLibrary\Platform\AbstractPlatform;
use Jan\GamesLibrary\Platform\BattleNet;
use Jan\GamesLibrary\Platform\Ea;
use Jan\GamesLibrary\Platform\EpicGames;
use Jan\GamesLibrary\Platform\Gog;
use Jan\GamesLibrary\Platform\Humble;
use Jan\GamesLibrary\Platform\Steam;
use Jan\GamesLibrary\Platform\Ubisoft;
use Jan\GamesLibrary\Platform\Unknown;
use Jan\GamesLibrary\Platform\Xbox;

final readonly class PlatformFactory
{
    public function getPlatformByName(string $name): Platform
    {
        return match ($name) {
            'Battle.net' => new BattleNet(),
            'Origin', 'EA app' => new Ea(),
            'Epic' => new EpicGames(),
            'GOG' => new Gog(),
            'Humble' => new Humble(),
            'Steam' => new Steam(),
            'Ubisoft', 'Ubisoft Connect' => new Ubisoft(),
            'Xbox' => new Xbox(),
            default => new Unknown($name)
        };
    }
}
