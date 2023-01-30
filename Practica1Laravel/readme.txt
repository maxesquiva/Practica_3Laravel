1- comando para crear nuevo proyecto laravel 
	-composer create-proyect laravel/laravel Practica1Laravel
2- arrancamos el servidor 
	-  php artisan serve
3- tras crear y conectar la bd nueva procedemos a crear la tabla alumno con migrations:
	-php artisan make:migration create_alumnos
4-tras crear la tabla alumno y escribir los atributos que va  a tener ejecutamos el comando:
	-php artisan migrate
5-vamos a crear un modelo:
	-php artisan make:model Alumno
6-ahora vamos a crear el seeder:
	-php artisan make:seeder AlumnoSeeder
7- ahora dentro de Database seder en la funcion run() llaamaremos al seeder AlumnoSeeder y ejecutaremos este comando para que ejecute en la db:
	-php artisan db:seed --class=AlumnoSeeder
8- ahora vamos a crear el controlador:
	-php artisan make:controller AlumnoController
9-Para crear el middleware y comprobar las especificacion del id usamos:
	-php artisan make:middleware AlumnoIdIsCorrect2   