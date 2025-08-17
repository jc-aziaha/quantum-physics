<?php
declare(strict_types=1);

namespace QuantumPhysics\Particles\Abstracts;

use QuantumPhysics\Enums\ConjugationType;
use QuantumPhysics\Exceptions\InvalidSpinException;
use QuantumPhysics\Particles\Abstracts\AbstractParticle;

/**
 * AbstractBoson
 *
 * Règles spécifiques aux bosons :
 * - spin entier (0, 1, 2, ...)
 * - famille 'boson'
 */
abstract class AbstractBoson extends AbstractParticle
{
    public function __construct(
        string $name,
        string $symbol,
        string $subFamily, // 'gauge'|'scalar'|'graviton' etc.
        float $spin,
        float $massMeV,
        float $charge,
        ?ConjugationType $conjugationType = null
    ) {
        parent::__construct($name, $symbol, 'boson', $spin, $massMeV, $charge, $conjugationType);
        // possibilité: stocker subFamily dans quantum numbers
    }

    protected function validatePhysics(): void
    {
        if (!$this->isBoson()) {
            throw new InvalidSpinException("Un boson doit avoir un spin entier. (Got: {$this->spin})");
        }
    }
}
