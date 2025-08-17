<?php
declare(strict_types=1);

require dirname(__DIR__) . "/vendor/autoload.php";

use QuantumPhysics\Factory\ParticleFactory;
use QuantumPhysics\Enums\ConjugationType;

function dumpParticle(\QuantumPhysics\Contracts\ParticleInterface $p): void
{
    echo "=== " . $p->getName() . " (" . $p->getSymbol() . ") ===<br/>";
    echo "Famille: " . $p->getFamily() . " | Spin: " . $p->getSpin() . " | Charge: " . $p->getCharge() . " | Masse (MeV): " . $p->getMassMeV() . "<br/>";
    echo "Stats: " . $p->statistics() . " | Stable: " . ($p->isStable() ? 'oui' : 'non') . "<br/>";

    $has = $p->hasAntiparticle();
    echo "hasAntiparticle(): " . (is_null($has) ? 'indéterminé' : ($has ? 'true' : 'false')) . "<br/>";

    try {
        $anti = $p->getAntiparticle();
        if ($anti !== null) {
            echo "Antiparticule: " . $anti->getName() . " (" . $anti->getSymbol() . "), charge=" . $anti->getCharge() . "<br/>";
        } else {
            echo "Auto-conjuguée (même que l'antiparticule).<br/>";
        }
    } catch (\Exception $e) {
        echo "Antiparticule: exception -> " . $e->getMessage() . "<br/>";
    }

    // Forces connues (extrait des forces attachées)
    echo "Interactions (stratégies enregistrées):<br/>";
    foreach ($p->getForces() as $f) {
        echo " - " . $f->getName() . " (interacts? " . ($f->interactsWith($p) ? 'oui' : 'non') . ")<br/>";
    }

    // Quantum numbers
    echo "Nombres quantiques:<br/>";
    foreach ($p->getQuantumNumbers() as $qn) {
        echo " - " . $qn->getName() . " = " . var_export($qn->getValue(), true) . "<br/>";
    }

    // Decay channels (if any)
    $dc = $p->decayChannels();
    if (count($dc) > 0) {
        echo "Canaux de désintégration (exemple pédagogique):<br/>";
        foreach ($dc as $c) {
            echo " -> " . implode(',', $c['products']) . " (BR=" . ($c['BR'] ?? 'n/a') . ")<br/>";
        }
    }

    echo "<br/>";
}

/** Demo **/
$elec = ParticleFactory::create('electron');
$ph = ParticleFactory::create('photon');
$z = ParticleFactory::create('Z');
$w = ParticleFactory::create('W+');
$h = ParticleFactory::create('higgs');
$nu = ParticleFactory::create('nu_e');

dumpParticle($elec);
dumpParticle($ph);
dumpParticle($z);
dumpParticle($w);
dumpParticle($h);
dumpParticle($nu);

// Montrer la gestion du neutrino (indéterminé -> choisir Dirac)
echo "--- fixation hypothèse neutrino --> Dirac (distinct) ---<br/>";
if (method_exists($nu, 'setAsDirac')) {
    $nu->setAsDirac();
}
dumpParticle($nu);
