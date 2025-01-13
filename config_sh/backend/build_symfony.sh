#! /bin/bash

cd ./saas_backend/
docker-compose up --build -d
docker-compose exec application composer install 
# dans le cas où les installations ne se sont pas faites, il est préférable de se protéger de cette erreur