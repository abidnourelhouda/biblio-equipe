<?php
require __DIR__ . '/../autoload.php';

$echecs = 0;

function verifier(bool $condition, string $message): void
{
    global $echecs;
    if ($condition) {
        echo "[OK] $message\n";
    } else {
        echo "[ECHEC] $message\n";
        $echecs++;
    }
}

foreach (glob(__DIR__ . '/test_*.php') as $fichier) {
    require $fichier;
}

echo $echecs === 0 ? "Tous les tests passent.\n" : "$echecs test(s) en echec.\n";
exit($echecs === 0 ? 0 : 1);
