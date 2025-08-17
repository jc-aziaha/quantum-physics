<?php
declare(strict_types=1);

namespace QuantumPhysics\Particles\Abstracts;

use QuantumPhysics\Contracts\ParticleInterface;
use QuantumPhysics\Contracts\QuantumNumberInterface;
use QuantumPhysics\Contracts\ForceInterface;
use QuantumPhysics\Enums\ConjugationType;
use QuantumPhysics\Exceptions\AntiparticleException;
use QuantumPhysics\Exceptions\InvalidSpinException;
use QuantumPhysics\Exceptions\InvalidChargeException;

/**
 * AbstractParticle
 *
 * Fournit l'implémentation commune à toutes les particules :
 * - propriétés physiques de base (name, symbol, spin, mass, charge)
 * - gestion des nombres quantiques (array d'objets)
 * - gestion des forces (stratégies)
 * - gestion de l'antiparticule via ConjugationType
 *
 * Notes physiques dans les commentaires des méthodes.
 */
abstract class AbstractParticle implements ParticleInterface
{
    protected string $name;
    protected string $symbol;
    protected string $family;

    protected float $spin;
    protected float $massMeV;
    protected float $charge;

    /** @var QuantumNumberInterface[] */
    protected array $quantumNumbers = [];

    /** @var ForceInterface[] */
    protected array $forces = [];

    /** indique si cette instance représente l'antiparticule (utile pour le clone) */
    protected bool $isAntiparticle = false;

    /** ConjugationType::DISTINCT | ::SELF | ::UNKNOWN */
    protected ConjugationType $conjugationType;

    /**
     * @param ConjugationType|null $conjugationType si null => ConjugationType::DISTINCT par défaut
     */
    public function __construct(
        string $name,
        string $symbol,
        string $family,
        float $spin,
        float $massMeV,
        float $charge,
        ?ConjugationType $conjugationType = null
    ) {
        // validations basiques (fail-fast)
        if ($name === '') {
            throw new \InvalidArgumentException("Le nom ne peut pas être vide.");
        }
        if ($symbol === '') {
            throw new \InvalidArgumentException("Le symbole ne peut pas être vide.");
        }
        if (!is_finite($spin) || $spin < 0.0) {
            throw new InvalidSpinException("Spin invalide fourni: " . var_export($spin, true));
        }
        if (!is_finite($massMeV) || $massMeV < 0.0) {
            throw new \InvalidArgumentException("Masse invalide (doit être >= 0).");
        }
        if (!is_finite($charge)) {
            throw new InvalidChargeException("Charge invalide.");
        }

        $this->name  = $name;
        $this->symbol = $symbol;
        $this->family = $family;
        $this->spin  = $spin;
        $this->massMeV = $massMeV;
        $this->charge = $charge;

        $this->conjugationType = $conjugationType ?? ConjugationType::DISTINCT;

        // Hook pour validations physiques plus précises (surchargé par les sous-classes)
        $this->validatePhysics();
    }

    /**
     * Validation par défaut : les sous-classes (Fermion/Boson) l'étendront.
     */
    protected function validatePhysics(): void
    {
        // rien par défaut ; les classes concrètes effectuent les checks spin/charge spécifiques.
    }

    // ----------------------
    // getters de base
    // ----------------------
    public function getName(): string { return $this->name; }
    public function getSymbol(): string { return $this->symbol; }
    public function getFamily(): string { return $this->family; }
    public function getSpin(): float { return $this->spin; }
    public function getMassMeV(): float { return $this->massMeV; }
    public function getCharge(): float { return $this->charge; }

    // ----------------------
    // quantum numbers
    // ----------------------
    /** @return QuantumNumberInterface[] */
    public function getQuantumNumbers(): array
    {
        return $this->quantumNumbers;
    }

    public function addQuantumNumber(QuantumNumberInterface $qn): void
    {
        $this->quantumNumbers[$qn->getName()] = $qn;
    }

    public function getQuantumNumber(string $name): ?QuantumNumberInterface
    {
        return $this->quantumNumbers[$name] ?? null;
    }

    // ----------------------
    // forces
    // ----------------------
    /** @return ForceInterface[] */
    public function getForces(): array
    {
        return $this->forces;
    }

    public function addForce(ForceInterface $force): void
    {
        // éviter doublons par nom
        foreach ($this->forces as $f) {
            if ($f->getName() === $force->getName()) {
                return;
            }
        }
        $this->forces[] = $force;
    }

    /**
     * Vérifie si la particule interagit avec la force nommée.
     * Implémentation : on recherche la Force correspondante (par getName()) et on délègue à la stratégie.
     *
     * Physique: par ex. Electromagnetic::interactsWith($this) vérifiera la charge.
     */
    public function interactsWith(string $forceName): bool
    {
        foreach ($this->forces as $force) {
            if ($force->getName() === $forceName) {
                return $force->interactsWith($this);
            }
        }
        // si la force n'est pas enregistrée comme stratégie, on considère qu'il n'y a pas d'interaction
        return false;
    }

    // ----------------------
    // classification & statistique
    // ----------------------
    protected function isNearlyInteger(float $x, float $eps = 1e-9): bool
    {
        return abs($x - round($x)) < $eps;
    }

    protected function isIntegerSpin(float $spin): bool
    {
        return $this->isNearlyInteger($spin);
    }

    protected function isHalfIntegerSpin(float $spin): bool
    {
        $twice = 2.0 * $spin;
        if (!$this->isNearlyInteger($twice)) return false;
        return ((int) round($twice)) % 2 !== 0;
    }

    public function isBoson(): bool
    {
        return $this->isIntegerSpin($this->spin);
    }

    public function isFermion(): bool
    {
        return $this->isHalfIntegerSpin($this->spin);
    }

    public function statistics(): string
    {
        return $this->isBoson() ? 'Bose-Einstein' : 'Fermi-Dirac';
    }

    // ----------------------
    // antiparticule
    // ----------------------
    public function hasAntiparticle(): ?bool
    {
        if ($this->conjugationType === ConjugationType::DISTINCT) return true;
        if ($this->conjugationType === ConjugationType::SELF) return false;
        return null; // UNKNOWN
    }

    /**
     * Construit et retourne une instance clone représentant l'antiparticule.
     *
     * Physique:
     *  - DISTINCT : on inverse la charge, on préfixe le nom par 'Anti-' et on marque l'instance comme antiparticule.
     *  - SELF     : la particule est auto-conjuguée — on renvoie un clone mais sans inversion.
     *  - UNKNOWN  : on lève AntiparticleException (ex: neutrino non fixé).
     *
     * Attention: cette méthode fournit une représentation pédagogique, pas une duplication complète de la physique.
     *
     * @throws AntiparticleException
     */
    public function getAntiparticle(): ?ParticleInterface
    {
        if ($this->conjugationType->name === ConjugationType::UNKNOWN->name) {
            // (utiliser ->name pour comparaison d'énum)
            throw new AntiparticleException("Antiparticule indéterminée pour {$this->name}.");
        }

        // clone superficiel ; on marque isAntiparticle
        $anti = clone $this;
        $anti->isAntiparticle = !$this->isAntiparticle;

        if ($this->conjugationType === ConjugationType::DISTINCT) {
            // inverse la charge et transforme le nom/symbole (convention pédagogique)
            $anti->charge = -$this->charge;
            $anti->name = $this->isAntiparticle ? preg_replace('/^Anti-/', '', $this->name) : 'Anti-' . $this->name;
            $anti->symbol = $this->toggleBar($this->symbol);
            // Pour les nombres quantiques (ex: lepton number), on inverse la valeur s'il faut :
            // Par simplicité, si un LeptonNumber/BaryonNumber existe et est int, on inverse :
            foreach ($anti->quantumNumbers as $k => $qn) {
                // si l'objet supporte getValue() et setValue (non généralisé ici), on l'inverserait.
                // Nous gardons les QN identiques sauf si une logique spécifique est ajoutée.
            }
        } else {
            // SELF : on garde charge/name/symbol identiques (auto-conjuguée)
            // on peut toutefois marquer le nom si nécessaire : ici on garde inchangé.
        }

        return $anti;
    }

    /**
     * Ajout utilitaire pour basculer le "bar" sur symbole (convention pédagogique).
     */
    protected function toggleBar(string $symbol): string
    {
        $combining = "̅"; // combining overline
        // naive add/remove
        if (mb_substr($symbol, -1) === $combining) {
            return mb_substr($symbol, 0, mb_strlen($symbol) - 1);
        }
        return $symbol . $combining;
    }

    // ----------------------
    // désintégration / stabilité
    // ----------------------
    public function decayChannels(): array
    {
        // Par défaut: stable ou inconnue — les particules concrètes peuvent surcharger.
        return [];
    }

    public function isStable(): bool
    {
        return count($this->decayChannels()) === 0;
    }
}
