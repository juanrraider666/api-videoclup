# api-videoclup
Prueba tecnica para Api Rest en PHP symfony


## Instalación

- `Composer install`
-  [Database script](https://github.com/juanrraider666/api-videoclup/blob/release/1.0.0/db_api_videoclub.sql)
- `Ejecutar script continuar con comandos de doctrine.`
- `Conexion de BD en .env`

## Rutas API

- (consultar todas las peliculas )[https://127.0.0.1:8000/api/films][GET]
- (Listado de todas las películas por tipo )[https://127.0.0.1:8000/api/films/1][GET]
- (Alquiler para una o varias películas y cálculo del precio.)[https://127.0.0.1:8000/api/films/rental][

POST,
Body -> raw -> JSON ->
EXAMPLE:

```JSON
{

"user" : 2,
"film": 2,
"count": 1,
"days": 4
}
```
]

(Devolver los puntos de fidelización de un cliente)[https://127.0.0.1:8000/api/films/user/points/1]
