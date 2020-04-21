# **PHP CONSUMER CANVAS API**
Script PHP para realizar llamadas a la API de el LMS Canvas por medio de la autentificación por token.

## #  Instalación
1. Descarga el proyecto
2. Móntalo bajo un servicio web (por ejemplo Apache)
3. Crea en la raiz un archivo de nombre config.php con las variables globales $host y $access_key
4. 

## #  Ejemplo de archivo config.php

<?php

global $access_key, $host;

$host = "https://TU_DOMINIO_INSTANCIA_DE_CANVAS.instructure.com";
$access_key = "AQUI_TU_API_KEY";
