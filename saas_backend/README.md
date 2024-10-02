# Backend du SAAS

## Contexte

Le backend est généré avec symfony, merci de suivre les instructions du WEB ci-après en cliquant sur le lien **[ici](https://openclassrooms.com/fr/courses/7709361-construisez-une-api-rest-avec-symfony)**

## Modèle de conception

Par défaut, le backend est généré sur un modèle MVC, la vue ne sert pas en tant que telle, elle ne renverra pas d'HTML.
Le backend a pour objectif d'établir la logique métier et de renvoyer les informations nécessaires à l'API REST, elle est donc formée pour répondre à un besoin REST.

Vous trouverez les composants du modèle de conception dans le ***/src***.

```bash
cd src/
```

Le dossier **./src/** se compose de trois sous-dossiers :

- Controller : Instanciations des controllers de l'API REST : reçu de requêtes HTTP, définitions des valeurs renvoyées et routes de l'API
- Entity : Définition des classes de la BDD et de leur logique métier, instanciations des tables BDD en POO.
- Repository : Définition des classe CRUD sur les tables BDD.
- DataFixtures : Fichier de loader pour charger des données

Le principal de la définition du modèle se fera dans ce dossier.

## Instructions Modèle

Avant tout détails des commandes symfony, prenez en compte l'existence d'un utilitaire en shell mis à votre disposition pour vous simplifier le développement. Son utilisation se fait avec la commande à exécuter dans le répertoire **saas_backend/** :
```bash
bash conf_bash/utilitaire_saas.sh
```

Créer une entité en utilisant symfony :

```bash
php bin/console make:entity
```

Et suivez les instructions du terminal. Deux fichiers se créeront :
- L'entité définie
- Le repository CRUD associée

Instanciation de la BDD :

L'URL de connexion de la base de données est configurée dans le fichier **.env.local**. Merci de changer l'URL de connexion si la BDD est déplacée lors de la dockerisation.
Si des mise à jours sont à faire dans les config d'accès, merci de changer le paramètrage de doctrine dans le fichier config/packages/doctrine.yaml

Commande de création de la BDD :

```bash
php bin/console doctrine:database:create
```

Commande de mise à jour de la BDD pour instancier les changements du modèle dans la BDD :

```bash
php bin/console doctrine:schema:update --force
```

Pour charger les données du loader :

```bash
php bin/console doctrine:fixtures:load
```

Pour créer un Controller :

```bash
php bin/console make:controller
```

## Instructions de lancement du serveur

Pour lancer le serveur, vous avez deux options :

- Soit vous pouvez lancer le serveur vous-même en prenant en compte toutes les installations à faire sur votre propre poste au préalable avec l'instalaltion de PHP, composer et symfony. Une fois ces installations faites, merci d'installer toutes les dépendances nécessaires au projet avec la commande suivante :
    ```bash
    composer install
    ```
    Une fois toutes les dépendances installées, merci de lancer le serveur avec la commande suivante :
    ```bash
    symfony server:start
    ```

- Soit vous installez et démarrez l'application depuis les conteneurs docker mis à votre disposition. Pour cela, merci de vous rendre à la racine de votre projet et d'exécuter l'instruction ci-dessous :
    ```bash
    bash config_sh/backend/build_symfony.sh
    ```
    Une fois les services docker installées, lancez le serveur avec la commande suivante :
    ```bash
    bash config_sh/backend/start_backend.sh
    ```

Merci de regarder le postman fourni pour tester l'accessibilité avec votre navigateur WEB.