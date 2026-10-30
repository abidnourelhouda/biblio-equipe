<?php

/**
 * Classe Membre : represente un membre de la bibliotheque.
 *
 * Peut emprunter jusqu'a 3 livres maximum.
 */
class Membre
{
    private int $id;
    private string $nom;
    /** @var Livre[] */
    private array $emprunts = [];

    public function __construct(int $id, string $nom)
    {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Emprunte un livre (3 livres maximum).
     * @throws Exception si le membre a deja 3 emprunts
     */
    public function emprunter(Livre $l): void
    {
        if (count($this->emprunts) >= 3) {
            throw new Exception("Le membre {$this->nom} a atteint la limite de 3 emprunts.");
        }
        $l->emprunter();
        $this->emprunts[] = $l;
    }

    /**
     * Rend un livre.
     * @throws Exception si le livre n'est pas dans les emprunts du membre
     */
    public function rendre(Livre $l): void
    {
        $index = null;
        foreach ($this->emprunts as $i => $emprunt) {
            if ($emprunt->getIsbn() === $l->getIsbn()) {
                $index = $i;
                break;
            }
        }
        if ($index === null) {
            throw new Exception("Le membre {$this->nom} n'a pas emprunte ce livre.");
        }
        $l->rendre();
        array_splice($this->emprunts, $index, 1);
    }

    /**
     * Retourne les livres empruntes.
     * @return Livre[]
     */
    public function getEmprunts(): array
    {
        return $this->emprunts;
    }
}
