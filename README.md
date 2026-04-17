# Knowledge Learning

Projet Symfony – Plateforme e-learning/e-commerce

## Installation

1. Cloner le dépôt :
git clone [URL_DU_DEPOT]

2. Installer les dépendances :
composer install

3. Créer la base de données et importer la structure :
- Créez une base vide (ex : `bdd_s03`)
- Importez le fichier `bdd_s03.sql` fourni à la racine du projet (via phpMyAdmin ou la ligne de commande MySQL)

4. Configurer le fichier `.env` si besoin (identifiants MySQL, etc.)

5. Lancer le serveur Symfony :
symfony server:start


## Identifiants de test

- **Admin**  
  Email : admin1@gmail.com  
  Mot de passe : 123456

- **User vérifié**  
  Email : test1@gmail.com  
  Mot de passe : 123456

- **User non vérifié**  
  Email : test2@gmail.com  
  Mot de passe : 123456

## Fonctionnalités principales

- Création de compte avec validation par mail
- Connexion utilisateur/admin
- Achat de formations ou de leçons
- Validation de leçons et obtention de certifications
- Espace administrateur pour la gestion des utilisateurs et contenus

---
