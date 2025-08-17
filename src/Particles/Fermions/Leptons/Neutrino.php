<?php
declare(strict_types=1);

namespace QuantumPhysics\Particles\Fermions\Leptons;

use QuantumPhysics\Forces\Weak;
use QuantumPhysics\Forces\Gravity;
use QuantumPhysics\Enums\ConjugationType;
use QuantumPhysics\QuantumNumbers\LeptonNumber;
use QuantumPhysics\Particles\Abstracts\AbstractFermion;

/**
 * Neutrino électronique
 *
 * - fermion, spin 1/2
 * - charge 0
 * - masse petite (ici pédagogique : 0.01 MeV)
 * - conjugaison par défaut UNKNOWN (Dirac vs Majorana encore incertain expérimentalement)
 */
class Neutrino extends AbstractFermion
{
    public function __construct()
    {
        parent::__construct(
            'Neutrino électronique',
            'νₑ',
            'lepton',
            0.5,
            0.01,    // valeur pédagogique, très approximative
            0.0,
            ConjugationType::UNKNOWN
        );

        $this->addQuantumNumber(new LeptonNumber(1));
        $this->addForce(new Weak());
        $this->addForce(new Gravity());
    }

    /**
     * Définir explicitement l'hypothèse Dirac (nu != anti-nu)
     */
    public function setAsDirac(): static
    {
        $this->conjugationType = ConjugationType::DISTINCT;
        return $this;
    }

    /**
     * Définir explicitement l'hypothèse Majorana (nu == anti-nu)
     */
    public function setAsMajorana(): static
    {
        $this->conjugationType = ConjugationType::SELF;
        return $this;
    }
}
