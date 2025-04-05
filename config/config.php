<?php
// Configuración de la aplicación
define('APP_NAME', 'Blog de Pokémon');
define('APP_VERSION', '1.0.0');
define('BASE_URL', 'http://localhost/pokemon-blog');

// Configuración de la API de Pokémon
define('POKEAPI_BASE_URL', 'https://pokeapi.co/api/v2');
define('POKEMON_PER_PAGE', 12);

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'pokemon_blog');

// Configuración de zona horaria
date_default_timezone_set('America/Mexico_City');

// Manejo de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
