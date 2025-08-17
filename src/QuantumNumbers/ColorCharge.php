<?php
declare(strict_types=1);

namespace QuantumPhysics\QuantumNumbers;

/**
 * ColorCharge
 *
 * Représente la "couleur" de charge forte pour les quarks / gluons.
 * Physique: valeurs usuelles 'red', 'green', 'blue' pour quarks,
 * et pour les anti-couleurs 'anti-red' etc. Les gluons portent des
 * combinaisons de couleur/anticouleur (modélisation simplifiée ici).
 *
 * Ici on accepte un set restreint de valeurs pour faciliter la validation.
 */
class ColorCharge extends AbstractQuantumNumber
{
    private const ALLOWED = [
        'red', 'green', 'blue',
        'anti-red', 'anti-green', 'anti-blue',
        'colorless' // ex: hadrons composites ou particules sans couleur
    ];

    public function __construct(string $value)
    {
        parent::__construct('color', $value);
    }

    public function isValid(): bool
    {
        return is_string($this->value) && in_array($this->value, self::ALLOWED, true);
    }
}
