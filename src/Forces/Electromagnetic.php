<?php
declare(strict_types=1);

namespace QuantumPhysics\Forces;

use QuantumPhysics\Contracts\ForceInterface;
use QuantumPhysics\Contracts\ParticleInterface;

/**
 * Electromagnetic force
 *
 * En première approximation: toute particule avec une charge électrique non nulle
 * couple à l'électromagnétisme.
 *
 * NOTE pédagogique: exceptions existent (ex: effets de neutralité effective),
 * mais pour le modèle ici on se base sur getCharge() != 0.
 */
class Electromagnetic implements ForceInterface
{
    public function getName(): string
    {
        return 'electromagnetic';
    }

    public function interactsWith(ParticleInterface $particle): bool
    {
        // Interaction si charge électrique non nulle
        return abs($particle->getCharge()) > 0.0;
    }

    public function description(): string
    {
        return 'Interaction électromagnétique: couple à la charge électrique.';
    }
}
