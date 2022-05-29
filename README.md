# ticketModule

go to ticketModule/.docker
1. cp .env.dist .env
2. docker-compose up -d
3. docker exec -it ticket-apache bash
4. cd webapp/
5. composer install
6. php bin/console d:s:u --force
7. php bin/console admin:user:add $user_email $password $role(ROLE_ADMIN/ROLE_CLIENT) -> komenda dodająca użytkownika
