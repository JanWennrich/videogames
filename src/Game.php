<?php

namespace Jan\GamesLibrary;

use Jan\GamesLibrary\GameAttribute\Feature;
use Jan\GamesLibrary\GameAttribute\Genre;
use Jan\GamesLibrary\GameAttribute\Score\CommunityScore;
use Jan\GamesLibrary\GameAttribute\Score\CriticScore;
use Jan\GamesLibrary\GameAttribute\Platform;
use Jan\GamesLibrary\GameAttribute\Playtime;

final readonly class Game
{
    /**
     * @param Feature[] $features
     * @param Genre[] $genres
     */
    public function __construct(
        public string $name,
        public Platform $platform,
        public Playtime $playtime,
        public bool $isInstalled,
        public string $description,
        public bool $isFavorite,
        public array $features,
        public array $genres,
        public CommunityScore $communityScore,
        public CriticScore $criticScore
    ) {
    }

    public function isCouchCoopGame(): bool
    {
        $couchCoopFeature = new Feature('Supports Couch Co-Op');

        return in_array($couchCoopFeature, $this->features);
    }
}
