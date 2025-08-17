<?php
declare(strict_types=1);

namespace QuantumPhysics\Contracts;

/**
 * Interface pour un nombre quantique typé.
 *
 * Physique: les nombres quantiques (baryon number, lepton number, couleur, isospin...)
 * sont représentés par de petits objets pour garantir de la validation
 * et encapsuler la logique de vérification.
 */
interface QuantumNumberInterface
{
    /**
     * Nom du nombre quantique (ex: "baryon", "lepton", "color")
     */
    public function getName(): string;

    /**
     * Valeur (peut être int, string, ou structure selon le QN).
     * Ex: baryon=1, lepton=1, color="red"
     */
    public function getValue(): mixed;

    /**
     * Validation locale du nombre quantique.
     * Par ex: BaryonNumber::isValid() vérifie que la valeur est entière.
     */
    public function isValid(): bool;
}
