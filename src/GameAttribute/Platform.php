<?php

namespace Jan\GamesLibrary\GameAttribute;

interface Platform
{
    public function getIconPath(): string;

    public function getName(): string;
}
