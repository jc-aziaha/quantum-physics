<?php
declare(strict_types=1);

namespace QuantumPhysics\Contracts;

use QuantumPhysics\Contracts\QuantumNumberInterface;

/**
 * Contrat minimal d'une particule pour ce modèle pédagogique.
 *
 * Note: certaines méthodes retournent des objets (QuantumNumberInterface, ForceInterface)
 * pour permettre une validation forte et des stratégies extensibles.
 */
interface ParticleInterface
{
    public function getName(): string;
    public function getSymbol(): string;
    public function getFamily(): string; // e.g. 'fermion'|'boson'

    public function getSpin(): float;    // valeur en unités de ħ (ex: 0.5, 1.0)
    public function getMassMeV(): float; // masse au repos en MeV/c^2
    public function getCharge(): float;  // charge électrique (unités de e)

    // --- quantum numbers ---
    /** @return QuantumNumberInterface[] */
    public function getQuantumNumbers(): array;
    public function addQuantumNumber(QuantumNumberInterface $qn): void;
    public function getQuantumNumber(string $name): ?QuantumNumberInterface;

    // --- forces / interactions ---
    /** @return \QuantumPhysics\Contracts\ForceInterface[] */
    public function getForces(): array;
    public function addForce(\QuantumPhysics\Contracts\ForceInterface $force): void;
    public function interactsWith(string $forceName): bool;

    // --- antiparticule ---
    /**
     * Retour:
     *   - true  => antiparticule distincte
     *   - false => auto-conjuguée (elle est égale à son anti)
     *   - null  => indéterminé (ex: neutrino avant choix Dirac/Majorana)
     */
    public function hasAntiparticle(): ?bool;

    /**
     * Retourne l'instance de l'antiparticule (clone) ou null si auto-conjuguée.
     * Peut lancer une exception si l'antiparticule est indéterminée.
     */
    public function getAntiparticle(): ?ParticleInterface;

    // --- autres utilitaires pédagogiques ---
    /** retourne 'Bose-Einstein' ou 'Fermi-Dirac' */
    public function statistics(): string;

    /** canaux de désintégration pédagogiques (tableau) */
    public function decayChannels(): array;
    public function isStable(): bool;
}
