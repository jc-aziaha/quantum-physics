<?php
declare(strict_types=1);

namespace QuantumPhysics\Forces;

use QuantumPhysics\Contracts\ForceInterface;
use QuantumPhysics\Contracts\ParticleInterface;

/**
 * Weak force (simplified)
 *
 * Dans ce modèle pédagogique, on considère que:
 * - tous les leptons et quarks subissent l'interaction faible (changement de saveur),
 *   mais l'intensité dépend de chiralité/isospin (non modélisé ici).
 *
 * On considère une particule "faible" si elle appartient à la famille 'fermion' ou
 * si elle est un boson de jauge faible (W/Z) — l'implémentation peut vérifier
 * via getFamily() ou le nom.
 */
class Weak implements ForceInterface
{
    public function getName(): string
    {
        return 'weak';
    }

    public function interactsWith(ParticleInterface $particle): bool
    {
        $fam = strtolower($particle->getFamily());
        // Fermions (quarks/leptons) interagissent via la force faible.
        if ($fam === 'fermion') {
            return true;
        }

        // Les bosons de jauge faibles (W/Z) interagissent également.
        $symbol = $particle->getSymbol();
        if (in_array($symbol, ['W⁺','W⁻','Z⁰','W+','W-','Z'], true)) {
            return true;
        }

        return false;
    }

    public function description(): string
    {
        return 'Interaction faible: responsable des désintégrations bêta et changement de saveur.';
    }
}
