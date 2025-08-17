<?php
declare(strict_types=1);

namespace QuantumPhysics\Exceptions;

/**
 * Lancée quand une charge invalide est donnée (ex: valeur non numérique),
 * ou si une particule neutre est définie avec une charge non-nulle par erreur.
 */
class InvalidChargeException extends PhysicsException {}
