# PowerCash - Application E-commerce

## Description du projet

PowerCash est une application web e-commerce développée avec Symfony. Elle permet aux utilisateurs de parcourir différentes catégories de produits, de consulter les détails des produits, d'ajouter des articles à leur panier et de consulter les informations relatives à leur compte utilisateur.

## Fonctionnalités

### Pour les utilisateurs standards (ROLE_USER)
- Inscription et connexion au site (y compris avec Google)
- Navigation par catégories de produits (Montres, Casques audio, Vêtements, etc.)
- Recherche de produits
- Consultation des fiches produits détaillées
- Ajout de produits au panier
- Gestion du panier (modification des quantités, suppression d'articles)
- Accès à un espace personnel avec les informations du compte
- Formulaire de contact

### Pour les administrateurs (ROLE_ADMIN)
- Toutes les fonctionnalités utilisateur
- Gestion des produits (ajout, modification, suppression, restauration)
- Gestion des utilisateurs (consultation des détails)

## Structure du projet

```
EvalSymfony/
├── config/
│   ├── packages/
│   ├── routes/
│   ├── bundles.php
│   ├── routes.yaml
│   └── services.yaml
├── migrations/
├── public/
│   ├── css/
│   ├── images/
│   ├── js/
│   └── index.php
├── src/
│   ├── Controller/
│   │   ├── AccountController.php
│   │   ├── ContactController.php
│   │   ├── DashboardController.php
│   │   ├── HomeController.php
│   │   ├── PanierController.php
│   │   ├── ProduitController.php
│   │   ├── RegistrationController.php
│   │   ├── RootController.php
│   │   ├── SecurityController.php
│   │   └── UserController.php
│   ├── DataFixtures/
│   │   ├── AppFixtures.php
│   │   ├── CategorieFixtures.php
│   │   ├── ImageFixtures.php
│   │   ├── MessageContactFixtures.php
│   │   └── ProduitFixtures.php
│   ├── Entity/
│   │   └── Utilisateur.php
│   ├── Form/
│   │   ├── ProduitFormType.php
│   │   ├── RegistrationFormType.php
│   │   └── UtilisateurType.php
│   └── Repository/
│       ├── CategorieRepository.php
│       ├── ImageRepository.php
│       ├── MessageContactRepository.php
│       ├── ProduitRepository.php
│       ├── UserRepository.php
│       └── UtilisateurRepository.php
└── templates/
    ├── account/
    ├── contact/
    ├── dashboard/
    ├── home/
    ├── panier/
    ├── produit/
    ├── registration/
    ├── root/
    ├── security/
    ├── user/
    └── base.html.twig
```

## Technologies utilisées

- **Symfony** - Framework PHP pour le backend
- **Twig** - Moteur de templates
- **Bootstrap** - Framework CSS pour le frontend
- **JavaScript** - Pour les fonctionnalités dynamiques côté client
- **MySQL/PostgreSQL** - Base de données (à confirmer)
- **HWI OAuth Bundle** - Pour l'authentification via Google

## Installation

1. **Cloner le dépôt**
   ```bash
   git clone [URL_DU_REPO]
   cd EvalSymfony
   ```

2. **Installer les dépendances**
   ```bash
   composer install
   ```

3. **Configurer la base de données**
   - Créer un fichier `.env.local` à partir du `.env`
   - Configurer la variable `DATABASE_URL` avec vos informations de connexion

4. **Créer la base de données**
   ```bash
   php bin/console doctrine:database:create
   ```

5. **Exécuter les migrations**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

6. **Charger les données de test (optionnel)**
   ```bash
   php bin/console doctrine:fixtures:load
   ```

7. **Lancer le serveur de développement**
   ```bash
   symfony server:start
   ```

## Utilisation

1. Accès au site: `http://localhost:8000`
2. Créer un compte ou se connecter
3. Parcourir les catégories ou rechercher des produits
4. Ajouter des produits au panier et gérer vos commandes

## Pages principales

- **Accueil** - Présentation des produits phares et ventes populaires
- **Catégories** - Navigation par type de produit
- **Recherche** - Résultats de recherche de produits
- **Produit** - Détails d'un produit avec option d'ajout au panier
- **Panier** - Gestion des articles sélectionnés
- **Mon Espace** - Informations personnelles de l'utilisateur
- **Admin - Gestion Produits** - Interface d'administration des produits
- **Admin - Gestion Utilisateurs** - Interface d'administration des utilisateurs

## Captures d'écran

*À ajouter ultérieurement*

## Auteur

*Votre nom*

## Licence

*À préciser*