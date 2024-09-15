<?php

namespace Jan\GamesLibrary;

use Jan\GamesLibrary\GameScore\GameCommunityScore;
use Jan\GamesLibrary\GameScore\GameCriticScore;

final readonly class Game
{
    /**
     * @param GameFeature[] $features
     * @param GameGenre[] $genres
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
        public GameCommunityScore $communityScore,
        public GameCriticScore $criticScore
    ) {
    }

    public function isCouchCoopGame(): bool
    {
        $couchCoopFeature = new GameFeature('Supports Couch Co-Op');

        return in_array($couchCoopFeature, $this->features);
    }
}
