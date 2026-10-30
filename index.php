<?php
require __DIR__ . '/autoload.php';

/**
 * Menu interactif de la bibliotheque Biblio.
 * 1 Ajouter | 2 Lister | 3 Rechercher | 4 Emprunter | 5 Rendre | 0 Quitter
 */

$bibliotheque = new Bibliotheque();
$membre = new Membre(1, 'Utilisateur');

function lireEntree(string $prompt): string
{
    echo $prompt;
    $ligne = fgets(STDIN);
    if ($ligne === false) {
        return '';
    }
    return trim($ligne);
}

function menu(): void
{
    echo "\n=== Biblio : Gestion de Bibliotheque ===\n";
    echo "1. Ajouter un livre\n";
    echo "2. Lister les livres\n";
    echo "3. Rechercher un livre\n";
    echo "4. Emprunter un livre\n";
    echo "5. Rendre un livre\n";
    echo "0. Quitter\n";
}

while (true) {
    menu();
    $choix = lireEntree("Votre choix : ");

    switch ($choix) {
        case '1':
            $isbn = lireEntree("ISBN (10 ou 13 chiffres) : ");
            $titre = lireEntree("Titre : ");
            $auteur = lireEntree("Auteur : ");
            try {
                $livre = new Livre($isbn, $titre, $auteur);
                $bibliotheque->ajouter($livre);
                echo "Livre ajoute avec succes.\n";
            } catch (Exception $e) {
                echo "Erreur : " . $e->getMessage() . "\n";
            }
            break;

        case '2':
            $livres = $bibliotheque->tous();
            if (empty($livres)) {
                echo "Aucun livre dans la bibliotheque.\n";
            } else {
                echo "--- Liste des livres ({$bibliotheque->compter()}) ---\n";
                foreach ($livres as $livre) {
                    echo "  " . $livre . "\n";
                }
            }
            break;

        case '3':
            $mot = lireEntree("Mot-cle : ");
            $resultats = $bibliotheque->rechercher($mot);
            if (empty($resultats)) {
                echo "Aucun resultat pour '$mot'.\n";
            } else {
                echo "--- Resultats (" . count($resultats) . ") ---\n";
                foreach ($resultats as $livre) {
                    echo "  " . $livre . "\n";
                }
            }
            break;

        case '4':
            $isbn = lireEntree("ISBN du livre a emprunter : ");
            $livre = $bibliotheque->trouver($isbn);
            if ($livre === null) {
                echo "Livre non trouve.\n";
            } else {
                try {
                    $membre->emprunter($livre);
                    echo "Livre emprunte par {$membre->getNom()}.\n";
                } catch (Exception $e) {
                    echo "Erreur : " . $e->getMessage() . "\n";
                }
            }
            break;

        case '5':
            $isbn = lireEntree("ISBN du livre a rendre : ");
            $livre = $bibliotheque->trouver($isbn);
            if ($livre === null) {
                echo "Livre non trouve.\n";
            } else {
                try {
                    $membre->rendre($livre);
                    echo "Livre rendu.\n";
                } catch (Exception $e) {
                    echo "Erreur : " . $e->getMessage() . "\n";
                }
            }
            break;

        case '0':
            echo "Au revoir !\n";
            exit(0);

        default:
            echo "Choix invalide.\n";
            break;
    }
}
