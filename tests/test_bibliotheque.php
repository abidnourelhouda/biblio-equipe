<?php
// Tests pour la classe Bibliotheque

$bib = new Bibliotheque();

// Test : bibliotheque vide
verifier($bib->compter() === 0, 'Bibliotheque vide : compter() retourne 0');
verifier($bib->tous() === [], 'Bibliotheque vide : tous() retourne un tableau vide');

// Test : ajouter un livre
$l1 = new Livre('9782100545261', 'Algorithmique', 'Cormen');
$bib->ajouter($l1);
verifier($bib->compter() === 1, 'Apres ajout : compter() retourne 1');

// Test : ajouter un deuxieme livre
$l2 = new Livre('9780132350884', 'Clean Code', 'Robert Martin');
$bib->ajouter($l2);
verifier($bib->compter() === 2, 'Apres 2 ajouts : compter() retourne 2');

// Test : ajouter un troisieme livre
$l3 = new Livre('9780201633610', 'Design Patterns', 'Gamma');
$bib->ajouter($l3);
verifier($bib->compter() === 3, 'Apres 3 ajouts : compter() retourne 3');

// Test : ajout avec ISBN duplique
$exceptionDup = false;
try {
    $bib->ajouter(new Livre('9782100545261', 'Duplicate', 'Test'));
} catch (Exception $e) {
    $exceptionDup = true;
}
verifier($exceptionDup, 'Ajouter un ISBN deja present leve une exception');

// Test : trouver par ISBN existant
$trouve = $bib->trouver('9782100545261');
verifier($trouve !== null && $trouve->getTitre() === 'Algorithmique', 'trouver() retourne le bon livre');

// Test : trouver par ISBN inexistant
verifier($bib->trouver('0000000000') === null, 'trouver() retourne null si ISBN absent');

// Test : tous() retourne tous les livres
verifier(count($bib->tous()) === 3, 'tous() retourne les 3 livres');

// Test : rechercher par titre (insensible a la casse)
$res = $bib->rechercher('algo');
verifier(count($res) === 1 && $res[0]->getTitre() === 'Algorithmique', 'rechercher("algo") trouve Algorithmique');

// Test : rechercher par auteur
$res2 = $bib->rechercher('martin');
verifier(count($res2) === 1 && $res2[0]->getTitre() === 'Clean Code', 'rechercher("martin") trouve Clean Code');

// Test : rechercher sans resultat
$res3 = $bib->rechercher('python');
verifier(count($res3) === 0, 'rechercher("python") ne trouve rien');

// Test : rechercher qui retourne plusieurs resultats
$l4 = new Livre('9780596007126', 'Algo Avance', 'Cormen');
$bib->ajouter($l4);
$res4 = $bib->rechercher('algo');
verifier(count($res4) === 2, 'rechercher("algo") trouve 2 livres');

// Test : statistiques d'une bibliotheque vide
$bibStats = new Bibliotheque();
verifier(
    $bibStats->getStatistiques() === [
        'total' => 0,
        'disponibles' => 0,
        'empruntes' => 0,
        'taux' => 0,
    ],
    'getStatistiques() retourne des statistiques nulles pour une bibliotheque vide'
);

// Test : statistiques avec des livres disponibles et empruntes
$livreStats1 = new Livre('9780321125217', 'Refactoring', 'Martin Fowler');
$livreStats2 = new Livre('9780131103627', 'The C Programming Language', 'Kernighan');
$livreStats3 = new Livre('9780201616224', 'The Pragmatic Programmer', 'Hunt');
$bibStats->ajouter($livreStats1);
$bibStats->ajouter($livreStats2);
$bibStats->ajouter($livreStats3);
verifier(
    $bibStats->getStatistiques() === [
        'total' => 3,
        'disponibles' => 3,
        'empruntes' => 0,
        'taux' => 100.0,
    ],
    'getStatistiques() compte les livres tous disponibles'
);

$livreStats1->emprunter();
verifier(
    $bibStats->getStatistiques() === [
        'total' => 3,
        'disponibles' => 2,
        'empruntes' => 1,
        'taux' => 66.67,
    ],
    'getStatistiques() compte les emprunts et arrondit le taux a deux decimales'
);

$livreStats1->rendre();
verifier(
    $bibStats->getStatistiques() === [
        'total' => 3,
        'disponibles' => 3,
        'empruntes' => 0,
        'taux' => 100.0,
    ],
    'getStatistiques() met a jour les statistiques apres un retour'
);
