<?php
declare(strict_types=1);

namespace QuantumPhysics\Particles\Bosons\Gauge;

use QuantumPhysics\Forces\Weak;
use QuantumPhysics\Forces\Gravity;
use QuantumPhysics\Enums\ConjugationType;
use QuantumPhysics\Forces\Electromagnetic;
use QuantumPhysics\Particles\Abstracts\AbstractBoson;

/**
 * Boson W⁺
 *
 * - boson de jauge faible, spin 1
 * - charge +1 (antiparticule W⁻)
 */
class BosonWPlus extends AbstractBoson
{
    public function __construct()
    {
        parent::__construct('Boson W⁺', 'W⁺', 'gauge', 1.0, 80379.0, +1.0, ConjugationType::DISTINCT);
        $this->addForce(new Weak());
        $this->addForce(new Gravity());
        $this->addForce(new Electromagnetic()); // il a une charge -> couple électro aussi
    }
}
