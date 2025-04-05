<?php
// Generar ID de usuario único si no existe
function getUserId() {
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = session_id();
    }
    return $_SESSION['user_id'];
}

// Formatear fecha para mostrar
function formatDate($dateString) {
    $date = new DateTime($dateString);
    $now = new DateTime();
    $interval = $now->diff($date);
    
    if ($interval->y > 0) {
        return $interval->y . ' año' . ($interval->y > 1 ? 's' : '') . ' atrás';
    } elseif ($interval->m > 0) {
        return $interval->m . ' mes' . ($interval->m > 1 ? 'es' : '') . ' atrás';
    } elseif ($interval->d > 0) {
        return $interval->d . ' día' . ($interval->d > 1 ? 's' : '') . ' atrás';
    } elseif ($interval->h > 0) {
        return $interval->h . ' hora' . ($interval->h > 1 ? 's' : '') . ' atrás';
    } elseif ($interval->i > 0) {
        return $interval->i . ' minuto' . ($interval->i > 1 ? 's' : '') . ' atrás';
    } else {
        return 'Ahora mismo';
    }
}

// Obtener nombre de estadística en español
function getStatName($statName) {
    $statNames = [
        'hp' => 'PS',
        'attack' => 'Ataque',
        'defense' => 'Defensa',
        'special-attack' => 'At. Esp.',
        'special-defense' => 'Def. Esp.',
        'speed' => 'Velocidad'
    ];
    
    return $statNames[$statName] ?? $statName;
}

// Capitalizar primera letra
function capitalizeFirst($string) {
    return ucfirst($string);
}

// Reemplazar guiones con espacios y capitalizar
function formatName($string) {
    return ucwords(str_replace('-', ' ', $string));
}

// Procesar envíos de formularios
function processFormSubmissions() {
    $userInteraction = new UserInteraction(getDbConnection());
    
    // Procesar comentarios
    if (isset($_POST['action']) && $_POST['action'] === 'add_comment') {
        if (isset($_POST['pokemon_id']) && isset($_POST['comment']) && isset($_POST['username'])) {
            $pokemonId = (int)$_POST['pokemon_id'];
            $comment = trim($_POST['comment']);
            $username = trim($_POST['username']);
            
            if (!empty($comment) && !empty($username)) {
                $userInteraction->addComment($pokemonId, $comment, $username);
            }
            
            // Redirigir de vuelta a la página de detalles
            header("Location: index.php?page=pokemon&id=$pokemonId#comments");
            exit;
        }
    }
}

// Procesar acciones de URL
function processUrlActions($action, $id) {
    $userInteraction = new UserInteraction(getDbConnection());
    
    switch ($action) {
        case 'like':
            if ($id) {
                $userInteraction->toggleLike($id);
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit;
            }
            break;
        case 'hide':
            if ($id) {
                $userInteraction->hidePokemon($id);
                header("Location: index.php");
                exit;
            }
            break;
    }
}

// Generar URL con parámetros de paginación
function getPaginationUrl($page) {
    $queryParams = $_GET;
    $queryParams['p'] = $page;
    return '?' . http_build_query($queryParams);
}
?>
