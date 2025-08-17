<?php
declare(strict_types=1);

namespace QuantumPhysics\Exceptions;

/**
 * Lancée quand un spin fourni est incompatible (ex: boson avec spin 1/2)
 * ou quand le spin n'est pas un nombre valide.
 *
 * Physique: protège l'invariant "fermion => half integer; boson => integer".
 */
class InvalidSpinException extends PhysicsException {}
