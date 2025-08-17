<?php
declare(strict_types=1);

namespace QuantumPhysics\QuantumNumbers;

/**
 * BaryonNumber
 *
 * Représente le nombre baryonique (B). En physique:
 * - baryons (protons, neutrons) ont B = +1,
 * - antibaryons ont B = -1,
 * - mésons ont B = 0.
 *
 * Ici on exige une valeur entière (ex: -1, 0, 1).
 */
class BaryonNumber extends AbstractQuantumNumber
{
    public function __construct(int $value)
    {
        parent::__construct('baryon', $value);
    }

    public function isValid(): bool
    {
        // B doit être un entier (typage déjà assuré) — on accepte toute valeur entière.
        return is_int($this->value);
    }
}
