<?php

namespace Jan\GamesLibrary;

interface Platform
{
    public function getIconPath(): string;

    public function getName(): string;
}
