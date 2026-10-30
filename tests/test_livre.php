<?php
// Tests pour la classe Livre

// Test : creation d'un livre avec ISBN 13 chiffres
$livre = new Livre('9782100545261', 'Algo', 'Cormen');
verifier($livre->getIsbn() === '9782100545261', 'getIsbn() retourne le bon ISBN');
verifier($livre->getTitre() === 'Algo', 'getTitre() retourne le bon titre');
verifier($livre->getAuteur() === 'Cormen', 'getAuteur() retourne le bon auteur');
verifier($livre->estDisponible(), 'Un nouveau livre est disponible');

// Test : creation d'un livre avec ISBN 10 chiffres
$livre10 = new Livre('2100545264', 'Test', 'Auteur');
verifier($livre10->getIsbn() === '2100545264', 'ISBN 10 chiffres accepte');

// Test : ISBN invalide (ni 10 ni 13 chiffres)
$exceptionIsbn = false;
try {
    new Livre('12345', 'Bad', 'ISBN');
} catch (InvalidArgumentException $e) {
    $exceptionIsbn = true;
}
verifier($exceptionIsbn, 'ISBN invalide leve InvalidArgumentException');

// Test : ISBN invalide vide
$exceptionVide = false;
try {
    new Livre('', 'Vide', 'ISBN');
} catch (InvalidArgumentException $e) {
    $exceptionVide = true;
}
verifier($exceptionVide, 'ISBN vide leve InvalidArgumentException');

// Test : emprunter un livre disponible
$livre->emprunter();
verifier(!$livre->estDisponible(), 'Apres emprunt, le livre est indisponible');

// Test : emprunter un livre deja emprunte
$exceptionEmprunt = false;
try {
    $livre->emprunter();
} catch (Exception $e) {
    $exceptionEmprunt = true;
}
verifier($exceptionEmprunt, 'Emprunter un livre deja emprunte leve une exception');

// Test : rendre un livre emprunte
$livre->rendre();
verifier($livre->estDisponible(), 'Apres rendu, le livre est disponible');

// Test : rendre un livre deja disponible
$exceptionRendre = false;
try {
    $livre->rendre();
} catch (Exception $e) {
    $exceptionRendre = true;
}
verifier($exceptionRendre, 'Rendre un livre deja disponible leve une exception');

// Test : __toString
$livreStr = new Livre('9782100545261', 'Algo', 'Cormen');
verifier(strpos((string)$livreStr, 'Algo') !== false, '__toString contient le titre');
verifier(strpos((string)$livreStr, 'Disponible') !== false, '__toString affiche Disponible');
