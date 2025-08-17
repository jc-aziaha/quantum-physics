<?php
declare(strict_types=1);

namespace QuantumPhysics\Exceptions;

/**
 * Lancée lors d'un nombre quantique mal formé ou non valide.
 * Par ex: BaryonNumber(value: 1.5) -> invalid.
 */
class InvalidQuantumNumberException extends PhysicsException {}
