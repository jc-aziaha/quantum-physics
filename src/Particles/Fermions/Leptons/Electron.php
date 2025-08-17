<?php
declare(strict_types=1);

namespace QuantumPhysics\Particles\Fermions\Leptons;

use QuantumPhysics\Forces\Weak;
use QuantumPhysics\Forces\Gravity;
use QuantumPhysics\Enums\ConjugationType;
use QuantumPhysics\Forces\Electromagnetic;
use QuantumPhysics\QuantumNumbers\LeptonNumber;
use QuantumPhysics\Particles\Abstracts\AbstractFermion;

/**
 * Electron
 *
 * - fermion, spin 1/2
 * - masse ~0.511 MeV
 * - charge -1
 * - Antiparticule distincte (positron)
 */
class Electron extends AbstractFermion
{
    public function __construct()
    {
        parent::__construct(
            'Electron',
            'e⁻',
            'lepton',
            0.5,
            0.51099895,
            -1.0,
            ConjugationType::DISTINCT
        );

        // Nombres quantiques : L = +1
        $this->addQuantumNumber(new LeptonNumber(1));

        // Forces : électromagnétisme (charge), faible (leptons), gravité (universelle)
        $this->addForce(new Electromagnetic());
        $this->addForce(new Weak());
        $this->addForce(new Gravity());
    }
}
