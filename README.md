# test-pagos360-api

[![N|Solid](https://cldup.com/dTxpPi9lDf.thumb.png)](https://nodesource.com/products/nsolid)

Test for company pagos360
# Requirements

Desarrollar una API que permita:
- Crear un Cliente (datos a recibir: Nombre, Apellido, DNI, Email; datos requeridos: Nombre, Apellido, DNI).
- Eliminar un Cliente.
- Actualizar los datos de un cliente.
- Listar los clientes existentes.
- Antes de guardar un nuevo cliente los campos de nombre y apellido deben guardarse en mayúscula.

Se valorara:
- Utilizar Synfony 3.2
- Segurización de la API.
- Prolijidad, estructura y comentarios en el código.
- Validación de tipos de datos.
- Utilización de composer.
- Utilzación de bundles tales como FOSUserBundle y FOSOAuthServerBundle.
  - Import a HTML file and watch it magically convert to Markdown
  - Drag and drop images (requires your Dropbox account be linked)

### add client to auth

```sql
INSERT INTO `oauth2_clients` (`id`, `random_id`, `redirect_uris`, `secret`, `allowed_grant_types`) VALUES
(1, '3bcbxd9e24g0gk4swg0kwgcwg4o8k8g4g888kwc44gcc0gwwk4', 'a:0:{}', '4ok2x70rlfokc8g0wws8c8kwcokw80k44sg48goc0ok4w0so0k', 'a:1:{i:0;s:8:\"password\";}');
```
