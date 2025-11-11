# Instructions d'installation du système d'authentification Ludos

## 📋 Étapes d'installation

### 1. Configuration de la base de données

Créez un fichier `.env.local` à la racine du projet avec le contenu suivant :

```env
# Configuration de la base de données MySQL (Laragon)
DATABASE_URL="mysql://root:@127.0.0.1:3306/ludos_db?serverVersion=8.0&charset=utf8mb4"

# Secret de l'application (générez une chaîne aléatoire)
APP_SECRET='votre_secret_aleatoire_ici'
```

### 2. Création de la base de données

Ouvrez un terminal dans le dossier `Carte_jeux` et exécutez :

```bash
# Créer la base de données
php bin/console doctrine:database:create

# Exécuter les migrations pour créer la table users
php bin/console doctrine:migrations:migrate
```

### 3. Vider le cache Symfony

```bash
php bin/console cache:clear
```

### 4. Lancer le serveur de développement Symfony

```bash
# Option 1: Serveur Symfony
symfony server:start

# Option 2: Serveur PHP intégré
php -S localhost:8000 -t public/
```

### 5. Accéder aux pages

Une fois le serveur lancé, vous pouvez accéder aux pages suivantes :

- **Page d'accueil** : `http://localhost:8000/accueil`
- **Inscription** : `http://localhost:8000/inscription`
- **Connexion** : `http://localhost:8000/connexion`
- **Profil** (nécessite d'être connecté) : `http://localhost:8000/profil`

## 🎯 Fonctionnalités

### Pages créées

1. **Page d'inscription (`/inscription`)** :
   - Formulaire avec nom d'utilisateur, email et mot de passe
   - Validation des données
   - Hash sécurisé du mot de passe
   - Chaque utilisateur commence avec 1000 pièces

2. **Page de connexion (`/connexion`)** :
   - Formulaire de connexion avec nom d'utilisateur et mot de passe
   - Option "Se souvenir de moi"
   - Protection CSRF
   - Messages d'erreur en cas d'échec

3. **Page de profil (`/profil`)** :
   - Affichage des informations du compte
   - Statistiques de jeu (parties jouées, victoires, score total)
   - Solde de pièces
   - Taux de victoire calculé automatiquement
   - Accès aux différentes sections (jeu, boutique, classement)

4. **Page d'accueil (`/accueil`)** :
   - Page d'accueil avec liens vers toutes les fonctionnalités
   - Affichage conditionnel selon l'état de connexion
   - Liens vers inscription/connexion ou profil/déconnexion

### Entité User

L'entité `User` contient les champs suivants :
- `username` : Nom d'utilisateur unique (3-180 caractères)
- `email` : Email unique
- `password` : Mot de passe hashé
- `roles` : Rôles de l'utilisateur (JSON)
- `coins` : Pièces de monnaie (défaut: 1000)
- `totalGames` : Nombre total de parties jouées
- `totalWins` : Nombre total de victoires
- `totalScore` : Score total cumulé
- `createdAt` : Date de création du compte

### Méthodes utiles de l'entité User

```php
// Gestion des pièces
$user->getCoins();
$user->setCoins(1500);
$user->addCoins(100);      // Ajoute 100 pièces
$user->removeCoins(50);    // Retire 50 pièces

// Gestion des statistiques
$user->incrementTotalGames();     // Incrémente le nombre de parties
$user->incrementTotalWins();      // Incrémente le nombre de victoires
$user->addToTotalScore(250);      // Ajoute 250 au score total
$user->getWinRate();              // Retourne le taux de victoire en %
```

## 🔐 Sécurité

### Configuration (security.yaml)

Le fichier `config/packages/security.yaml` est configuré pour :
- Hash automatique des mots de passe avec bcrypt
- Provider Doctrine pour charger les utilisateurs depuis la base de données
- Formulaire de connexion avec protection CSRF
- Fonction "Se souvenir de moi" (7 jours)
- Déconnexion sécurisée
- Protection de la route `/profil` (nécessite ROLE_USER)

### Routes protégées

Pour protéger d'autres routes, utilisez :

```php
// Dans un contrôleur
$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

// Ou dans security.yaml
access_control:
    - { path: ^/admin, roles: ROLE_ADMIN }
    - { path: ^/profil, roles: ROLE_USER }
```

## 🎨 CSS

Les styles d'authentification sont dans `public/assets/css/style-auth.css` :
- Design moderne avec dégradés
- Formulaires stylisés
- Messages d'erreur et de succès
- Design responsive
- Animations et transitions
- Cartes de statistiques animées

## 🔄 Intégration avec le jeu

Pour intégrer les statistiques du jeu avec l'utilisateur connecté :

```php
// Dans un contrôleur de jeu
if ($this->getUser()) {
    $user = $this->getUser();
    
    // Après une partie
    $user->incrementTotalGames();
    
    // Si victoire
    if ($joueurGagne) {
        $user->incrementTotalWins();
        $user->addToTotalScore($score);
        $user->addCoins($recompense);
    }
    
    // Sauvegarder les modifications
    $entityManager->flush();
}
```

## 📝 Notes importantes

1. **Base de données** : Assurez-vous que MySQL est démarré dans Laragon
2. **Mot de passe** : Les mots de passe doivent contenir au moins 6 caractères
3. **Email** : L'adresse email doit être valide et unique
4. **Nom d'utilisateur** : Doit contenir au moins 3 caractères et être unique
5. **Cache** : Si vous modifiez des entités ou la configuration, pensez à vider le cache

## 🐛 Dépannage

### Erreur de base de données
```bash
# Vérifier la connexion
php bin/console doctrine:database:create

# Vérifier les migrations
php bin/console doctrine:migrations:status
```

### Erreur de cache
```bash
php bin/console cache:clear
```

### Erreur de permissions
Sur Windows avec Laragon, pas de problème normalement. Sur Linux/Mac :
```bash
chmod -R 777 var/cache var/log
```

## 🚀 Prochaines étapes possibles

- Ajouter la fonctionnalité "Mot de passe oublié"
- Implémenter un système de confirmation d'email
- Ajouter un système de classement mondial
- Intégrer les achats de la boutique avec les pièces
- Ajouter des achievements/trophées
- Créer un système de matchmaking multijoueur

Bonne utilisation ! 🎴

