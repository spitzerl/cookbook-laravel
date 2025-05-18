# Cookbook - Application de Gestion de Recettes

Une application de gestion de recettes de cuisine développée avec Laravel et SQLite.

## Fonctionnalités

- Gestion des recettes (créer, lire, mettre à jour, supprimer)
- Catégorisation des recettes
- Gestion des ingrédients avec quantités
- Interface utilisateur intuitive
- Stockage des images de recettes
- Recherche et filtrage des recettes

## Prérequis

- PHP 8.0 ou supérieur
- Composer
- SQLite (installé par défaut)
- Extensions PHP : pdo_sqlite
- Node.js et NPM (facultatif, pour les assets front-end)

## Installation

### 1. Cloner le dépôt

```bash
git clone https://github.com/votre-utilisateur/cookbook.git
cd cookbook
```

### 2. Installer les dépendances

```bash
composer install
```

### 3. Configuration de la base de données

Le projet utilise SQLite. Pour configurer la base de données :

```bash
# Créer le fichier de base de données SQLite vide
touch database/database.sqlite

# Lancer les migrations pour créer les tables
php artisan migrate

# Remplir la base de données avec des données initiales (catégories, ingrédients et recettes d'exemple)
php artisan db:seed
```

### 4. Lien symbolique pour le stockage

```bash
php artisan storage:link
```

Si la commande échoue, vous pouvez créer manuellement le lien symbolique:
```bash
# Sur Linux/macOS
ln -s $(pwd)/storage/app/public $(pwd)/public/storage
# Sur Windows (cmd admin)
mklink /D "C:\chemin\vers\projet\public\storage" "C:\chemin\vers\projet\storage\app\public"
```

### 5. Démarrer le serveur de développement

```bash
# Utiliser le serveur de développement Laravel
php artisan serve

# OU utiliser directement le serveur intégré de PHP
php -S localhost:8000 -t public
```

L'application sera accessible à l'adresse [http://localhost:8000](http://localhost:8000).

## Données pré-remplies

Lors de l'installation, le seeder ajoutera automatiquement :

- Un compte utilisateur de test (email: test@example.com)
- 5 catégories de recettes (Entrées, Plats principaux, Desserts, Boissons, Soupes)
- 30 ingrédients courants
- 5 recettes d'exemple avec leurs ingrédients et instructions

Vous pouvez commencer à utiliser l'application immédiatement avec ces données ou ajouter vos propres recettes.

## Structure de la base de données

Le projet utilise les tables suivantes:

- `recipes`: Stocke les informations des recettes
- `categories`: Contient les catégories de recettes
- `ingredients`: Liste tous les ingrédients disponibles
- `ingredient_recipe`: Table pivot pour la relation many-to-many entre recettes et ingrédients

## Utilisation

### Interface d'administration

- `/recipes` - Liste des recettes
- `/recipes/create` - Créer une nouvelle recette
- `/categories` - Gérer les catégories
- `/ingredients` - Gérer les ingrédients

## Développement

### Commandes utiles

- `php artisan make:model NomDuModel -mcr` - Créer un modèle avec migration et contrôleur associés
- `php artisan route:list` - Afficher toutes les routes disponibles
- `php artisan migrate:fresh --seed` - Recréer toutes les tables de la base de données et les remplir avec les données des seeders
- `php artisan db:seed` - Remplir la base de données avec des données de test

### Structure des fichiers

- `app/Models/` - Contient les modèles Eloquent (Recipe, Category, Ingredient)
- `app/Http/Controllers/` - Contient les contrôleurs
- `database/migrations/` - Contient les migrations de base de données
- `database/seeders/` - Contient les seeders pour les données de test
- `resources/views/` - Contient les templates Blade
- `routes/web.php` - Définit les routes de l'application

## Notes importantes

- Les images téléchargées sont stockées dans `storage/app/public/recipe-images/`

## Licence

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus de détails.

## Contact

Pour toute question ou suggestion concernant ce projet, n'hésitez pas à nous contacter.
