# Proyecto integrador enero - junio 2024

## Materias

1. Análisis y diseño de sistemas de software
2. Desarrollo de aplicaciones web

## Requerimientos funcionales

1. Gestión del proceso completo de prácticas profesionales, bajo los lineamientos de la Institución.
2. Descarga y subida de los formatos que se manejan durante todo el proceso.
3. Implementación de las reglas de tiempo y cantidad de horas requeridas para dar por terminado el proceso.
4. Aceptación o rechazo de la documentación entregada por los estudiantes desde los usuarios de la academia.
5. Consulta de la situación (sin iniciar, por iniciar, iniciado, por terminar, terminado) que guarda cada proceso de prácticas de la licenciatura.
6. Generación de informes o reportes que apoyen a las necesidades de la academia, filtrando al menos por tiempo, situación, documentos, empresa y licenciatura.

## Requerimientos no funcionales

### De interfaz de usuario

1. Contar una interfaz de usuario simple con un nivel de complejidad bajo el cual sea capaz de ser utilizado incluso por personas con poca experiencia en el uso de e-mail, redes sociales o portales de noticias.
2. Contar con la imagen (colores) y logotipo de la Institución.
3. Toda la interfaz del sistema deberá ser adaptativa en dispositivos móviles.
4. Cuidar la ortografía y redacción de los mensaje del sistema.
5. Mostrar mensajes de retroalimentación claros y concisos.
6. Mostrar mensajes como "No hay elementos" o "No hay información" en aquellas pantallas que no tengan información registrada.
7. Procurar la consistencia visual/gráfica en todas las pantallas del sistema, cuidando estilo de texto, tamaño de fuente, iconos, colores, fuentes, márgenes, etc.
8. Realizar las validaciones de tipo de datos o datos faltantes en aquellos controles o campos de entrada que así lo requieran.

### De seguridad y rendimiento

1. Solo usuarios autenticados y con el rol definido podrán administrar el sistema.
2. El acceso de los usuarios utilizando mátricula o número de empleado (únicos en todo el sistema) y contraseña.
3. Las contraseñas de los usuarios **no** se almacena en texto plano.
4. Mecanismos de cambio y/o recuperación de contraseña.
5. Las contraseñas de los usuarios deberá ser al menos de 6 caracteres de longitud.
6. Definir o limitar el acceso a las funcionalidades de usuarios de la academia a través de roles o perfiles.
7. Cada registro o actualización de información deberá ser acompañada del usuario, dirección ip, fecha, hora en la que se dio el hecho.
8. Manejo de la validez o caducidad de sesiones de usuario de la administración.
9. Mantener tiempos de respuesta del sistema menores a 1 segundo.

## Funcionalidades

### Proceso de negocio
1. Generación de un PDF con información de cotización o envío.
2. Administración de cotizaciones (cliente y UCC).
3. Administración de envíos (cliente y UCC).
4. Administración de direcciones.

### Informes y estadísticas
1. Cotizaciones por estado, cliente, destinatario o periodo de tiempo.
2. Envíos por estado, cliente, destinatario, periodo de tiempo o paquetería.  
   
### Globales
1. Login.
2. Control de acceso / sesión.
3. Recuperación de contraseña.
4. Envíos de correos electrónicos.

### Otras tareas
1. Administración de base de datos.
