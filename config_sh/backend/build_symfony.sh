#! /bin/bash

cd ./saas_backend/
docker-compose up --build -d
docker-compose exec application composer install 

# on demande si l'utilisateur veut lancer la PROD
read -p "Voulez-vous lancer la base de données de production ? (y/n) : " prod
if [ $prod == "y" ]; then
    docker-compose exec application php bin/console doctrine:database:create --env=prod
    docker-compose exec application php bin/console doctrine:schema:update --force --env=prod
    docker-compose exec application php bin/console doctrine:fixtures:load
fi
# dans le cas où les installations ne se sont pas faites, il est préférable de se protéger de cette erreur