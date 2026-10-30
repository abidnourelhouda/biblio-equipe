<?php
// Tests pour la classe Membre

// Test : creation d'un membre
$m = new Membre(1, 'Alice');
verifier($m->getId() === 1, 'getId() retourne le bon id');
verifier($m->getNom() === 'Alice', 'getNom() retourne le bon nom');
verifier(count($m->getEmprunts()) === 0, 'Nouveau membre : aucun emprunt');

// Test : emprunter un livre
$livre1 = new Livre('9782100545261', 'Algo', 'Cormen');
$m->emprunter($livre1);
verifier(count($m->getEmprunts()) === 1, 'Apres 1 emprunt : 1 livre');
verifier(!$livre1->estDisponible(), 'Le livre est indisponible apres emprunt par le membre');

// Test : emprunter un deuxieme livre
$livre2 = new Livre('9780132350884', 'Clean Code', 'Martin');
$m->emprunter($livre2);
verifier(count($m->getEmprunts()) === 2, 'Apres 2 emprunts : 2 livres');

// Test : emprunter un troisieme livre (limite)
$livre3 = new Livre('9780201633610', 'Patterns', 'Gamma');
$m->emprunter($livre3);
verifier(count($m->getEmprunts()) === 3, 'Apres 3 emprunts : 3 livres (limite atteinte)');

// Test : emprunter un quatrieme livre (depasse la limite de 3)
$livre4 = new Livre('9780596007126', 'UML', 'Fowler');
$exceptionLimite = false;
try {
    $m->emprunter($livre4);
} catch (Exception $e) {
    $exceptionLimite = true;
}
verifier($exceptionLimite, 'Emprunter un 4eme livre leve une exception (limite 3)');
verifier($livre4->estDisponible(), 'Le 4eme livre reste disponible apres exception');

// Test : rendre un livre
$m->rendre($livre1);
verifier(count($m->getEmprunts()) === 2, 'Apres rendu : 2 emprunts');
verifier($livre1->estDisponible(), 'Le livre rendu est de nouveau disponible');

// Test : rendre un livre non emprunte
$livreExt = new Livre('9780134685991', 'Java', 'Bloch');
$exceptionNonEmprunte = false;
try {
    $m->rendre($livreExt);
} catch (Exception $e) {
    $exceptionNonEmprunte = true;
}
verifier($exceptionNonEmprunte, 'Rendre un livre non emprunte leve une exception');

// Test : apres rendu, on peut re-emprunter
$m->emprunter($livre1);
verifier(count($m->getEmprunts()) === 3, 'Apres re-emprunt : 3 livres');
