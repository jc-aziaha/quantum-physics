<?php
declare(strict_types=1);

namespace QuantumPhysics\Particles\Bosons\Gauge;

use QuantumPhysics\Forces\Weak;
use QuantumPhysics\Forces\Gravity;
use QuantumPhysics\Enums\ConjugationType;
use QuantumPhysics\Particles\Abstracts\AbstractBoson;

/**
 * Boson Z
 *
 * - boson de jauge faible, spin 1
 * - masse ~91.1876 GeV => 91187.6 MeV
 * - neutre, auto-conjugué
 */
class BosonZ extends AbstractBoson
{
    public function __construct()
    {
        parent::__construct('Boson Z', 'Z⁰', 'gauge', 1.0, 91187.6, 0.0, ConjugationType::SELF);
        $this->addForce(new Weak());
        $this->addForce(new Gravity());
    }
}
