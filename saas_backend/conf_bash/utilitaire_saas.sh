#! /bin/bash

question="\nQuelle instructions voulez-vous exécutez ?"
echo -e $question

taille=$(expr length "${question}")
for ((i=0; i<taille; i++)); do
    echo -n "-"
done

echo # pour la saut de ligne

echo -e "\t1. Utiliser le loader pour charger des données"
echo -e "\t2. Mettre à jour la BDD avec les changements du modèle"
echo -e "\t3. Créer une Entité"
echo -e "\t4. Créer un Controller"
echo -e "\t5. Exécuter les tests Unitaires"
echo -e "\t6. Exécuter les tests d'EndPoints API"
echo -e "\t7. Exécuter les tests de Repository"
echo -e "\t8. Exécuter les tests unitaires avec le coverage"
echo -e "\t9. Vérifier le respect des normes de codage"
echo -e "\t10. Corriger les erreurs de codage"
echo -e "\t11. Générer la documentation API"
echo -e "\t12. Créer la base de données de test"
echo -e "\t13. Créer un test"

read -p "Entrer l'instruction demandée : " instruction

if [ $instruction == "1" ]; then
    docker-compose exec application php bin/console doctrine:fixtures:load # entre dans le shell interfactif du container BDD
elif [ $instruction == "2" ]; then
    # docker-compose exec application php bin/console doctrine:schema:update --force # entre dans le shell interfactif du container BDD
    docker-compose exec application php bin/console make:migration
    docker-compose exec application php bin/console doctrine:migrations:migrate
elif [ $instruction == "3" ]; then
    docker-compose exec application php bin/console make:entity
elif [ $instruction == "4" ]; then
    docker-compose exec application php bin/console make:controller
elif [ $instruction == "5" ]; then
    docker-compose exec application vendor/bin/phpunit --testdox --colors tests/Entity
elif [ $instruction == "6" ]; then
    docker-compose exec application vendor/bin/phpunit --testdox --colors tests/Controller
elif [ $instruction == "7" ]; then
    docker-compose exec application vendor/bin/phpunit --testdox --colors tests/Repository
elif [ $instruction == "8" ]; then
    docker-compose exec application vendor/bin/phpunit --coverage-text tests/Entity
elif [ $instruction == "9" ]; then
    docker-compose exec application vendor/bin/phpcs -p --standard=PSR12 src
elif [ $instruction == "10" ]; then
    docker-compose exec application vendor/bin/phpcbf src
elif [ $instruction == "11" ]; then
    docker-compose exec application php bin/console nelmio:apidoc:dump --format=json > doc/openapi.json
elif [ $instruction == "12" ]; then
    docker-compose exec application php bin/console doctrine:database:create --env=test
    docker-compose exec application php bin/console doctrine:schema:update --force --env=test
elif [ $instruction == "13" ]; then
    docker-compose exec application php bin/console make:test
else
    echo "Instruction non reconnue"
fi

# exécuter une requête SQL : docker-compose exec application php bin/console doctrine:query:sql "REQUETE SQL"
# Créer la base de données : docker-compose exec application php bin/console doctrine:database:create
# Supprimer la base de données : docker-compose exec application php bin/console doctrine:database:drop --force
