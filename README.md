# test QUADMINDS

Test for company Quadminds

### Requerimientos
- PHP
- MySQL
- Composer

### Instalacion

```console
composer install
```

Al terminar de instalar los paquetes pedira datos de conexion a la base datos, entre otros


**La base de datos debe existir en MySQL**

### crear tablas
```console
php bin/console doctrine:schema:create
```

*se instalaran tablas para autenticacion pero no se utilizan*

Iniciar servidor
```console
php bin/console server:run
```

### Configurar Web App

[Abrir web app de quadmind](https://stackblitz.com/edit/quadminds-notes-frontend)

En el archivo **config/paths.js** se encuentra la URL actual, la cual debe ser reemplazada por el endpoint del backend a desarrollar (utilizar, http://localhost:8000/api/).