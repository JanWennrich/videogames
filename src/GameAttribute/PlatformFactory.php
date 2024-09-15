<?php

namespace Jan\GamesLibrary\GameAttribute;

use Jan\GamesLibrary\GameAttribute\Platform\BattleNet;
use Jan\GamesLibrary\GameAttribute\Platform\Ea;
use Jan\GamesLibrary\GameAttribute\Platform\EpicGames;
use Jan\GamesLibrary\GameAttribute\Platform\Gog;
use Jan\GamesLibrary\GameAttribute\Platform\Humble;
use Jan\GamesLibrary\GameAttribute\Platform\Steam;
use Jan\GamesLibrary\GameAttribute\Platform\Ubisoft;
use Jan\GamesLibrary\GameAttribute\Platform\Unknown;
use Jan\GamesLibrary\GameAttribute\Platform\Xbox;
use Jan\GamesLibrary\Platform\AbstractPlatform;

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
