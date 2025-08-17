<?php
declare(strict_types=1);

namespace QuantumPhysics\Enums;

/**
 * ConjugationType
 *
 * Indique la relation particule ↔ antiparticule.
 * - DISTINCT : particule et antiparticule sont distinctes (ex: électron / positron)
 * - SELF     : la particule est sa propre antiparticule (ex: photon, Z, Higgs)
 * - UNKNOWN  : état indéterminé (ex: neutrino si on ne choisit pas Dirac/Majorana)
 */
enum ConjugationType: int
{
    case DISTINCT = 1;
    case SELF     = 2;
    case UNKNOWN  = 3;
}
