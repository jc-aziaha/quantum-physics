<?php
declare(strict_types=1);

namespace QuantumPhysics\Forces;

use QuantumPhysics\Contracts\ForceInterface;
use QuantumPhysics\Contracts\ParticleInterface;
use QuantumPhysics\QuantumNumbers\ColorCharge;

/**
 * Strong force (simplified)
 *
 * Ici: on suppose que si la particule possède un nombre quantique ColorCharge
 * différent de 'colorless', elle participe à l'interaction forte.
 *
 * NOTE: require that the Particle implementation expose a getQuantumNumbers() method
 * returning an array of QuantumNumber objects (we will add this in AbstractParticle).
 */
class Strong implements ForceInterface
{
    public function getName(): string
    {
        return 'strong';
    }

    public function interactsWith(ParticleInterface $particle): bool
    {
        // We assume the particle has getQuantumNumbers() => array of QN objects.
        if (!method_exists($particle, 'getQuantumNumbers')) {
            // If the particle doesn't expose quantum numbers, assume it does not interact strongly.
            return false;
        }

        foreach ($particle->getQuantumNumbers() as $qn) {
            if ($qn instanceof ColorCharge) {
                // colorless -> no strong interaction (e.g. leptons)
                return $qn->getValue() !== 'colorless';
            }
        }
        return false;
    }

    public function description(): string
    {
        return 'Interaction forte: couple aux charges de couleur (quarks & gluons).';
    }
}
