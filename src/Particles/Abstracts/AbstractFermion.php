<?php
declare(strict_types=1);

namespace QuantumPhysics\Particles\Abstracts;

use QuantumPhysics\Enums\ConjugationType;
use QuantumPhysics\Exceptions\InvalidSpinException;
use QuantumPhysics\Particles\Abstracts\AbstractParticle;

/**
 * AbstractFermion
 *
 * Règles spécifiques aux fermions :
 * - spin demi-entier (1/2, 3/2, ...)
 * - famille 'fermion' par convention
 */
abstract class AbstractFermion extends AbstractParticle
{
    public function __construct(
        string $name,
        string $symbol,
        string $subFamily, // 'lepton' ou 'quark' (sous-catégorie)
        float $spin,
        float $massMeV,
        float $charge,
        ?ConjugationType $conjugationType = null
    ) {
        parent::__construct($name, $symbol, 'fermion', $spin, $massMeV, $charge, $conjugationType);
        // on peut stocker la sous-famille comme quantum number si besoin
        $this->addQuantumNumber(new \QuantumPhysics\QuantumNumbers\LeptonNumber(0)); // placeholder si besoin
    }

    protected function validatePhysics(): void
    {
        if (!$this->isFermion()) {
            throw new InvalidSpinException("Un fermion doit avoir un spin demi-entier. (Got: {$this->spin})");
        }
    }
}
