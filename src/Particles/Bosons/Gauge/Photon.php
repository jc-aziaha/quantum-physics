<?php
declare(strict_types=1);

namespace QuantumPhysics\Particles\Bosons\Gauge;

use QuantumPhysics\Forces\Gravity;
use QuantumPhysics\Enums\ConjugationType;
use QuantumPhysics\Forces\Electromagnetic;
use QuantumPhysics\Particles\Abstracts\AbstractBoson;

/**
 * Photon
 *
 * - boson de jauge, spin 1
 * - masse 0, charge 0
 * - auto-conjugué (le photon est sa propre antiparticule)
 */
class Photon extends AbstractBoson
{
    public function __construct()
    {
        parent::__construct('Photon', 'γ', 'gauge', 1.0, 0.0, 0.0, ConjugationType::SELF);

        // Le photon "couple" à l'électromagnétisme (mais il n'a pas de charge propre)
        $this->addForce(new Electromagnetic());
        $this->addForce(new Gravity());
    }
}
