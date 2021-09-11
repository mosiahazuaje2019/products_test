## Aplicacion desarrollada en Laravel, Vuejs con Inertia y Tailwind

Siga las siguientes instrucciones luego de descargar el proyecto:

- Primeramente configure el archivo .env usando el .env.example como guia.
- Una vez configurado el .env asegurarse de tener una base de datos mysql y configurarla en el .env.
- Realizar el comando composer install para instalar todas las dependencias del proyecto.
- Realice un npm install.
- Haga un php artisan key:generate.
- Prosiga realizando el comando php artisan migrate para cargar todas las tablas del proyecto en su ambiente local.
- Finalmente podra hacer un npm run dev y luego un php artisan para correr la aplicacion en modo local.
- Debe crear un usuario en la opcion registrarse que esta en la pantalla de bienvenida.
- Procure crear registros de marcas antes de proceder a crear registros en la seccion de productos para que pueda visualizar el flujo correcto.

## Backend
Todo el backend se construyo utilizando Laravel, para esto se emplearon Resources para personalizar la salidas del endpoint que luego serian consumidos por el front.
Tambien se hizo uso de los Requests para configurar las validaciones, esto va vinculado a los Api Controller que se diseñaron estos controles retornan respuestas en formato json.
En cuanto a los modelos se definieron las relaciones pertinentes como es el caso de los modelos brands->products siendo una relacion de uno a muchos.
Se hace uso del middleware auth para asegurar el inicio de sesion y proteger las rutas, tambien se podria utilizar JWT sin embargo para este caso solo se utilizo auth.
 
## Frontend

Para el Frontend se empleo VueJS, Tailwind para los estilos y tambien se utiliza una libreria para componentes de Vue PrimeVue


### Version de Laravel 8 y Vue 3

## Desarrollado por Mosiah Azuaje
mosiahazuaje2010@gmail.com
https://www.linkedin.com/in/mosiah-azuaje-6a3b43b6/
https://github.com/mosiahazuaje2019/products_test