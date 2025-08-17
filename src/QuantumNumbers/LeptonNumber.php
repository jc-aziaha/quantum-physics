<?php
declare(strict_types=1);

namespace QuantumPhysics\QuantumNumbers;

/**
 * LeptonNumber
 *
 * Représente le nombre leptoniqe (L). Par exemple:
 * - électron, neutrino -> L = +1,
 * - antileptons -> L = -1.
 *
 * Exige un entier.
 */
class LeptonNumber extends AbstractQuantumNumber
{
    public function __construct(int $value)
    {
        parent::__construct('lepton', $value);
    }

    public function isValid(): bool
    {
        return is_int($this->value);
    }
}
