<?php
declare(strict_types=1);

namespace QuantumPhysics\Particles\Bosons\Scalar;

use QuantumPhysics\Forces\Weak;
use QuantumPhysics\Forces\Gravity;
use QuantumPhysics\Enums\ConjugationType;
use QuantumPhysics\Forces\Electromagnetic;
use QuantumPhysics\Particles\Abstracts\AbstractBoson;

/**
 * Boson de Higgs (scalaire)
 *
 * - spin 0, masse ~125 GeV
 * - auto-conjugué
 */
class Higgs extends AbstractBoson
{
    public function __construct()
    {
        parent::__construct('Boson de Higgs', 'H⁰', 'scalar', 0.0, 125090.0, 0.0, ConjugationType::SELF);

        // Interactions (purement indicatives ici)
        $this->addForce(new Weak());
        $this->addForce(new Electromagnetic()); // Higgs interagit indirectement avec photon via boucles
        $this->addForce(new Gravity());
    }

    /**
     * Exemple pédagogique de canaux de désintégration.
     * Valeurs pédagogiques (non précises) pour la démonstration.
     */
    public function decayChannels(): array
    {
        return [
            ['products' => ['b','b̄'], 'BR' => 0.58],
            ['products' => ['W+','W-'], 'BR' => 0.21],
            ['products' => ['Z','Z'], 'BR' => 0.026],
            ['products' => ['γ','γ'], 'BR' => 0.002],
        ];
    }
}
