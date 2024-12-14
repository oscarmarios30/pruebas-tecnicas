# Pruebas Técnicas

Este repositorio contiene la solución a varias pruebas técnicas relacionadas con backend, frontend, y consultas SQL.

## Contenido

- **Backend**: API REST para gestionar un catálogo de productos usando Laravel.
- **Frontend**: Página web para gestionar el catálogo de productos.
- **Consultas-SQL.txt**: Consultas SQL para gestionar y analizar los datos.
- **bd-tienda**:base datos del proyecto

## Estructura del Proyecto

1. Clona el repositorio:
   git clone https://github.com/oscarmarios30/pruebas-tecnicas.git

migración para el catálogo de productos:
php artisan migrate

Configurar la conexión a la base de datos en el archivo .env y crear la base datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

Genera la clave de la aplicación:
php artisan key:generate

Prueba las siguientes rutas con herramientas como Postman o cURL:

POST http://127.0.0.1:8000/api/products - Crear un producto (requiere name, price).
GET http://127.0.0.1:8000/api/products/{id} - Obtener un producto específico.
PUT http://127.0.0.1:8000/api/products/{id} - Actualizar un producto (requiere name, price).
DELETE http://127.0.0.1:8000/api/products/{id} - Eliminar un producto.
