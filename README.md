# Certificat de Domicile

Application Laravel pour la gestion et la demande de certificats de domicile, destinée aux communes.

## Fonctionnalités

- **Gestion des habitants** : Ajout, modification et suppression d'habitants avec leurs informations détaillées (nom, prénom, téléphone, date et lieu de naissance, maison associée).
- **Gestion des maisons** : Enregistrement des maisons avec adresse, description, propriétaire et quartier.
- **Gestion des propriétaires et quartiers** : Création et gestion des propriétaires et quartiers.
- **Paramétrage de la commune** : Configuration des paramètres essentiels (nom de la commune, département, région, maire, prix du certificat) via une interface d’administration.
- **Demande de certificat** : Saisie et édition d’une demande de certificat de domicile par un habitant, génération et gestion de la signature du maire.
- **Authentification** : Création automatique de compte utilisateur lors de l’enregistrement d’un habitant, connexion et sécurisation des accès.
- **Journalisation** : Traçabilité des actions majeures via les logs.

## Prérequis

- PHP >= 8.1
- Composer
- Node.js et npm (pour le front-end avec Vite)
- SGBD compatible (SQLite par défaut, configuré dans `.env`)
- Docker (optionnel, support via Dockerfile fourni)

## Installation

1. **Cloner le dépôt**

   ```bash
   git clone https://github.com/kakiang/certificat-domicile.git
   cd certificat-domicile
   ```

2. **Installer les dépendances PHP**

   ```bash
   composer install
   ```

3. **Installer les dépendances front-end**

   ```bash
   npm install
   ```

4. **Configurer l’environnement**

   Copier le fichier `.env.example` en `.env` et renseigner vos paramètres de base de données :

   ```
   cp .env.example .env
   ```

   Exemple de configuration SQLite dans `.env` :
   ```
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database.sqlite
   ```

   Pour MySQL, renseignez :
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=certificat
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Générer la clé d’application**

   ```bash
   php artisan key:generate
   ```

6. **Créer la base de données et exécuter les migrations**

   ```bash
   php artisan migrate
   ```

   Les tables suivantes seront créées, en plus des tables propres à Laravel :
   - habitants
   - maisons
   - proprietaires
   - quartiers
   - certificats
   - parametres
   - payments

7. **Lancer le serveur de développement**

   ```bash
   php artisan serve
   ```

8. **Compiler les assets front-end**

   ```bash
   npm run dev
   ```

## Utilisation

- **Accéder à l’application** via [http://localhost:8000](http://localhost:8000)
- **Configurer les paramètres de la commune** via l’espace admin
- **Créer des maisons, habitants, propriétaires et quartiers**
- **Faire une demande de certificat** : Un habitant peut initier une demande, qui sera validée et signée par la mairie.

## Base de données

La configuration se fait via le fichier `.env` et le fichier `config/database.php`. Par défaut, SQLite est utilisé, mais MySQL, PostgreSQL ou autre peuvent être configurés.

Exécution des migrations (création des tables) :

```bash
php artisan migrate
```

## Docker

Pour lancer via Docker (Nginx + PHP-FPM) :

```bash
docker build -t certificat-domicile .
docker run -p 80:80 certificat-domicile
```

## Support & Contribuer

Pour toute amélioration ou question, ouvrez une issue ou une pull request sur le dépôt GitHub.
