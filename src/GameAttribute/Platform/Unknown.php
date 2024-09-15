<?php

namespace Jan\GamesLibrary\GameAttribute\Platform;

use Jan\GamesLibrary\GameAttribute\Platform;

final class Unknown implements Platform
{
    public function __construct(private readonly string $name)
    {
    }

    public function getIconPath(): string
    {
        return 'platform_icons/unknown.png';
    }

    public function getName(): string
    {
        return $this->name;
    }
}
