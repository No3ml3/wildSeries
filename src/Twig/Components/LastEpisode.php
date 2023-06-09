<?php

namespace App\Twig\Components;

use App\Repository\EpisodeRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent()]
final class LastEpisode
{
    public function __construct(
        private EpisodeRepository $EpisodeRepository
    ) {
    }

       public function getEpisode(): array
    {
        return $this->EpisodeRepository->findBy([], ['id' => 'DESC'], 3);
    }
}
