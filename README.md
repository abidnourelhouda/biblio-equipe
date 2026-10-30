# Biblio

Application PHP en ligne de commande pour gérer une bibliothèque (livres, membres, emprunts).

## Structure

```
biblio/
├── README.md
├── CHANGELOG.md
├── .gitignore
├── autoload.php
├── index.php          (menu interactif)
├── src/
│   ├── Livre.php
│   ├── Bibliotheque.php
│   └── Membre.php
└── tests/
    ├── run.php
    ├── test_livre.php
    ├── test_bibliotheque.php
    └── test_membre.php
```


## Contrat d'interface

- **Livre** : `__construct(isbn, titre, auteur)`, `getIsbn()`, `getTitre()`, `getAuteur()`, `estDisponible()`, `emprunter()`, `rendre()`, `__toString()`
- **Bibliotheque** : `ajouter(Livre)`, `trouver(isbn)`, `tous()`, `compter()`, `rechercher(mot)`
- **Membre** : `__construct(id, nom)`, `getId()`, `getNom()`, `emprunter(Livre)`, `rendre(Livre)`, `getEmprunts()`
