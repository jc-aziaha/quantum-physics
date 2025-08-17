<?php
declare(strict_types=1);

namespace QuantumPhysics\Forces;

use QuantumPhysics\Contracts\ForceInterface;
use QuantumPhysics\Contracts\ParticleInterface;

/**
 * Gravity (simplified)
 *
 * La gravité couple universellement à l'énergie/masse. Dans ce modèle,
 * on considère que toutes les particules "interagissent" gravitationnellement.
 * (En pratique: interaction négligeable à l'échelle des particules, mais présente.)
 */
class Gravity implements ForceInterface
{
    public function getName(): string
    {
        return 'gravity';
    }

    public function interactsWith(ParticleInterface $particle): bool
    {
        // Approche pédagogique : toutes les particules ont une masse (ou énergie),
        // donc gravity::interactsWith retourne true.
        return true;
    }

    public function description(): string
    {
        return 'Gravitation: interaction universelle couplant à la masse/énergie.';
    }
}
