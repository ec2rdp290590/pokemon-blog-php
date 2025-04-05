<?php
// Iniciar sesión para manejar las interacciones del usuario
session_start();

// Incluir archivos de configuración
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'includes/functions.php';

// Inicializar la base de datos si es necesario
initializeDatabase();

// Enrutamiento básico
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$id = isset($_GET['id']) ? $_GET['id'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;

// Procesar acciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    processFormSubmissions();
}

// Procesar acciones de URL
if ($action) {
    processUrlActions($action, $id);
}

// Incluir el encabezado
include 'includes/header.php';

// Cargar la página solicitada
switch ($page) {
    case 'home':
        include 'views/home.php';
        break;
    case 'blog':
        include 'views/blog_posts.php';
        break;
    case 'pokemon':
        if ($id) {
            include 'views/pokemon_detail.php';
        } else {
            // Redirigir a la página principal si no se proporciona un ID
            header('Location: index.php');
            exit;
        }
        break;
    case 'about':
        include 'views/about.php';
        break;
    default:
        // Página 404 o redirigir a la página principal
        include 'views/home.php';
        break;
}

// Incluir el pie de página
include 'includes/footer.php';
?>
