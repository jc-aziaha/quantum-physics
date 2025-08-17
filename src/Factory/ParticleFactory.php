<?php
declare(strict_types=1);

namespace QuantumPhysics\Factory;

use QuantumPhysics\Particles\Bosons\Gauge\BosonZ;
use QuantumPhysics\Particles\Bosons\Gauge\Photon;
use QuantumPhysics\Particles\Bosons\Scalar\Higgs;
use QuantumPhysics\Particles\Bosons\Gauge\BosonWPlus;
use QuantumPhysics\Particles\Bosons\Scalar\HiggsBoson;
use QuantumPhysics\Particles\Fermions\Leptons\Electron;
use QuantumPhysics\Particles\Fermions\Leptons\Neutrino;
use QuantumPhysics\Particles\Fermions\Leptons\ElectronNeutrino;

/**
 * Simple ParticleFactory / registry pédagogique.
 * On garde une approche statique simple pour l'exemple.
 */
class ParticleFactory
{
    protected static array $map = [];

    public static function register(string $id, callable $callable): void
    {
        self::$map[$id] = $callable;
    }

    public static function create(string $id)
    {
        if (!isset(self::$map[$id])) {
            throw new \InvalidArgumentException("Particule inconnue: {$id}");
        }
        return (self::$map[$id])();
    }
}

// Enregistrements par défaut
ParticleFactory::register('electron', fn() => new Electron());
ParticleFactory::register('photon', fn() => new Photon());
ParticleFactory::register('Z', fn() => new BosonZ());
ParticleFactory::register('W+', fn() => new BosonWPlus());
ParticleFactory::register('higgs', fn() => new Higgs());
ParticleFactory::register('nu_e', fn() => new Neutrino());
