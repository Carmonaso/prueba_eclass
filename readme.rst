###################
Prueba técnica eClass
###################



*******************
Herramientas utilizadas
*******************
- Framework MVC CodeIgniter 3.1.4
- Php 7.0
- MySql
- Bootstrap
- Chart.js

*******************
Configuraciones
*******************
- PHP: php/7.0/apache2/conf.d/php.ini: Las variables post_max_size y upload_max_filesize poseen un valor de 50M.

- MYSQL:
	* Usuario: prueba_eclass	Password:"" (vacío)
	* Base de datos: prueba_eclass
	* Tabla: atenciones

		- id (int) Clave Primaria
		- fecha (date)
		- id_forma_ingreso (int)
		- id_contacto_crm (int)
		- id_coordinadora_crm (int)
		- id_producto_agrupador (int)
		- id_oficina_comercial_crm (int)
		- deleted (bool)
-La carpeta uploads posee permisos necesarios para subir y eliminar archivos.

*******************
Suposiciones y Consideraciones
*******************
- Ya existen tablas de las cuales lleguen los atributos:
	*id_forma_ingreso
	*id_contacto_crm
	*id_coordinadora_crm
	*id_producto_agrupador
	*id_oficina_comercial_crm

Estríctamente estos atributos deberían ser claves foráneas, pero en esta ocasión se dejarán sólo como INT.


-Se considerará como cantidad de atenciones la cantidad de contactos crm únicos asignados a cada id_producto_agrupador.

-Se considerará como cantidad de coordinadoras la cantidad de coordinadoras crm únicas asignadas a cada id_producto_agrupador.


- Como prueba técnica se dio la facilidad de subir los archivos CSV para sean exportados a la base de datos.

-El archivo CSV debe ser otorgado con la misma estructura solicitada (separado con ";"" y con los mismos atributos).

