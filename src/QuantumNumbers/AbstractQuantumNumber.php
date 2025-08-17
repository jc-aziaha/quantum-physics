<?php
declare(strict_types=1);

namespace QuantumPhysics\QuantumNumbers;

use QuantumPhysics\Contracts\QuantumNumberInterface;
use QuantumPhysics\Exceptions\InvalidQuantumNumberException;

/**
 * AbstractQuantumNumber
 *
 * Base commune pour les nombres quantiques typés.
 * Fournit un constructeur et une méthode de validation forcée.
 *
 * Physique: encapsuler les règles de validité (ex: baryon number integre).
 */
abstract class AbstractQuantumNumber implements QuantumNumberInterface
{
    protected string $name;
    protected mixed $value;

    public function __construct(string $name, mixed $value)
    {
        $this->name  = $name;
        $this->value = $value;

        if (!$this->isValid()) {
            throw new InvalidQuantumNumberException(sprintf(
                "Nombre quantique %s invalide (%s).",
                $this->name,
                var_export($this->value, true)
            ));
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /**
     * Chaque sous-classe doit implémenter sa validation.
     */
    abstract public function isValid(): bool;
}
