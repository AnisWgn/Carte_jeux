# 🎴 Système d'authentification Ludos

## ✅ Fichiers créés

### Entité et Form
- ✅ `src/Entity/User.php` - Entité utilisateur avec Doctrine
- ✅ `src/Form/RegistrationFormType.php` - Formulaire d'inscription

### Contrôleur
- ✅ `src/Controller/SecurityController.php` - Gestion inscription/connexion/déconnexion/profil

### Templates Twig
- ✅ `templates/base.html.twig` - Template de base
- ✅ `templates/security/register.html.twig` - Page d'inscription
- ✅ `templates/security/login.html.twig` - Page de connexion
- ✅ `templates/security/profile.html.twig` - Page de profil
- ✅ `templates/security/accueil.html.twig` - Page d'accueil

### CSS
- ✅ `public/assets/css/style-auth.css` - Styles pour l'authentification et le profil

### Configuration
- ✅ `config/packages/security.yaml` - Configuration de la sécurité Symfony
- ✅ `migrations/Version20251111000000.php` - Migration pour créer la table users

### Documentation
- ✅ `INSTRUCTIONS_INSTALLATION.md` - Instructions détaillées d'installation

## 🚀 Routes disponibles

| Route | URL | Description | Accès |
|-------|-----|-------------|-------|
| `app_register` | `/inscription` | Formulaire d'inscription | Public |
| `app_login` | `/connexion` | Formulaire de connexion | Public |
| `app_logout` | `/deconnexion` | Déconnexion | Connecté |
| `app_accueil` | `/accueil` | Page d'accueil | Public |
| `app_profile` | `/profil` | Page de profil utilisateur | Connecté |

## 📊 Fonctionnalités de l'entité User

- Authentification avec nom d'utilisateur et mot de passe
- Hash sécurisé des mots de passe (bcrypt)
- Validation des données (email, username, password)
- Système de pièces de monnaie (1000 au départ)
- Statistiques de jeu (parties, victoires, score)
- Calcul automatique du taux de victoire

## 🎯 Utilisation

### 1. Configurer la base de données

Créez un fichier `.env.local` :

```env
DATABASE_URL="mysql://root:@127.0.0.1:3306/ludos_db?serverVersion=8.0&charset=utf8mb4"
APP_SECRET='votre_secret_ici'
```

### 2. Créer la base et exécuter les migrations

```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console cache:clear
```

### 3. Lancer le serveur

```bash
php -S localhost:8000 -t public/
```

### 4. Accéder aux pages

- Accueil : http://localhost:8000/accueil
- Inscription : http://localhost:8000/inscription
- Connexion : http://localhost:8000/connexion
- Profil : http://localhost:8000/profil (après connexion)

## 💡 Exemple d'utilisation dans le code

```php
// Vérifier si l'utilisateur est connecté
if ($this->getUser()) {
    $user = $this->getUser();
    
    // Récupérer les informations
    $username = $user->getUsername();
    $coins = $user->getCoins();
    $winRate = $user->getWinRate();
    
    // Ajouter des pièces
    $user->addCoins(100);
    
    // Enregistrer une partie
    $user->incrementTotalGames();
    if ($victoire) {
        $user->incrementTotalWins();
        $user->addToTotalScore($score);
    }
    
    // Sauvegarder
    $entityManager->flush();
}
```

## 🔐 Sécurité

- Protection CSRF activée
- Mots de passe hashés avec bcrypt
- Validation des données côté serveur
- Route `/profil` protégée (ROLE_USER requis)
- Session "Se souvenir de moi" (7 jours)

## 🎨 Design

Interface moderne avec :
- Dégradés de couleurs (violet/bleu)
- Animations et transitions
- Design responsive
- Formulaires stylisés
- Cartes de statistiques
- Affichage du solde de pièces

Pour plus de détails, consultez `INSTRUCTIONS_INSTALLATION.md`

