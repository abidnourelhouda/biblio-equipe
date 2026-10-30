<?php

/**
 * Classe Livre : represente un livre de la bibliotheque.
 *
 * Proprietes privees : isbn, titre, auteur, disponible.
 * Le constructeur leve InvalidArgumentException si l'ISBN n'a pas 10 ou 13 chiffres.
 */
class Livre
{
    private string $isbn;
    private string $titre;
    private string $auteur;
    private bool $disponible;

    /**
     * @param string $isbn  ISBN du livre (10 ou 13 chiffres)
     * @param string $titre Titre du livre
     * @param string $auteur Auteur du livre
     * @throws InvalidArgumentException si l'ISBN n'a pas 10 ou 13 chiffres
     */
    public function __construct(string $isbn, string $titre, string $auteur)
    {
        // Validation : l'ISBN doit contenir exactement 10 ou 13 chiffres
        $chiffres = preg_replace('/[^0-9]/', '', $isbn);
        if (strlen($chiffres) !== 10 && strlen($chiffres) !== 13) {
            throw new InvalidArgumentException("L'ISBN doit contenir 10 ou 13 chiffres.");
        }
        $this->isbn = $isbn;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->disponible = true;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }

    public function estDisponible(): bool
    {
        return $this->disponible;
    }

    /**
     * Emprunte le livre.
     * @throws Exception si le livre est deja emprunte
     */
    public function emprunter(): void
    {
        if (!$this->disponible) {
            throw new Exception("Le livre '{$this->titre}' est deja emprunte.");
        }
        $this->disponible = false;
    }

    /**
     * Rend le livre.
     * @throws Exception si le livre est deja disponible
     */
    public function rendre(): void
    {
        if ($this->disponible) {
            throw new Exception("Le livre '{$this->titre}' est deja disponible.");
        }
        $this->disponible = true;
    }

    public function __toString(): string
    {
        $statut = $this->disponible ? 'Disponible' : 'Emprunte';
        return "[{$this->isbn}] {$this->titre} par {$this->auteur} ({$statut})";
    }
}
