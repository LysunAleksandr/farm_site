
pizzeria showcase
https://github.com/LysunAleksandr/crt-symfony-4.git

#to install:

docker-compose up --build -d

docker-compose exec app composer install

#to create a database and tables, run the command 

docker-compose exec app php bin/console doctrine:migrations:migrate

#to download data

docker-compose exec app php bin/console --env=dev doctrine:fixtures:load

#to Generate the SSL keys:

docker-compose exec app php bin/console lexik:jwt:generate-keypair

#login admin

admin/admin

#the site will be available at

http://localhost/

#the API will be available at

http://localhost/api

#to create jwt token use endpoint

http://localhost/api/login_check

#example for Linux or macOS

curl -X POST -H "Content-Type: application/json" http://localhost/api/login_check -d '{"username":"johndoe","password":"test"}'

#example for Windows

curl -X POST -H "Content-Type: application/json" http://localhost/api/login_check --data {\"username\":\"johndoe\",\"password\":\"test\"}



