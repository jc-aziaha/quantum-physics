<?php
declare(strict_types=1);

namespace QuantumPhysics\Exceptions;

/**
 * Lancée quand on essaye d'obtenir l'antiparticule d'une particule
 * pour laquelle la conjugaison est indéterminée (ex: neutrino non fixé).
 */
class AntiparticleException extends PhysicsException {}
