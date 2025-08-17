<?php
declare(strict_types=1);

namespace QuantumPhysics\Contracts;

use QuantumPhysics\Contracts\ParticleInterface;

/**
 * Interface ForceInterface
 *
 * Représente une force (ou interaction) dans le simulateur/ modèle.
 * L'implémentation peut contenir de la logique pour décider si une particule
 * "couple" à cette force (par ex. électromagnétique => particules chargées).
 *
 * Physique:
 *  - Electromagnetic : couples to electric charge
 *  - Strong : couples to color charge (quarks, gluons)
 *  - Weak : couples via weak isospin / left-handed fermions
 *  - Gravity : couples to energy/mass (universel)
 */
interface ForceInterface
{
    /**
     * Nom lisible (ex: "electromagnetic")
     */
    public function getName(): string;

    /**
     * Retourne true si la particule fournie interagit avec cette force.
     *
     * Par exemple:
     *  - Electromagnetic::interactsWith($p) => true si $p->getCharge() != 0
     *  - Strong::interactsWith($p) => true si $p a ColorCharge
     *
     * Physique: utile pour construire des signatures, filtres ou calculs simplifiés.
     */
    public function interactsWith(ParticleInterface $particle): bool;

    /**
     * Optionnel: description textuelle utile pour affichage pédagogique.
     */
    public function description(): string;
}
