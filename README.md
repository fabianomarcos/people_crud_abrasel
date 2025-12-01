Para rodar com devcontainer, clonar o projeto e apertar F1 e dar um Reopen with dev container

##########################################################################


Para rodar no docker:

docker compose up --build -d

após os containers do mysql e do app subirem

docker exec -it people_app bash

cd person_crud

php artisan serve --host=0.0.0.0 --port=8000

O frontend vai rodar na localhost:8000 e o backend terá api/people com os verbos http


###########################################################################


Caso tenha o php instalado na máquina entrar na pasta person_crud e rodar php artisan serve --host=0.0.0.0 --port=8000
