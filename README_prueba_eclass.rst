###################
Prueba técnica eClass
###################



*******************
Herramientas utilizadas
*******************
- Framework MVC CodeIgniter
- Php 7.0
- MySql

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

*******************
Suposiciones
*******************
- Ya existen tablas de las cuales lleguen los atributos 
			id_forma_ingreso,
			id_contacto_crm,
			id_coordinadora_crm,
			id_producto_agrupador,
			id_oficina_comercial_crm.

Estríctamente deberían ser claves foráneas a estas claves pero en esta ocasión se dejarán sólo como INT.


*******************
Cómo funcionan las vistas
*******************



