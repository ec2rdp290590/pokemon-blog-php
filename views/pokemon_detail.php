<?php
require_once 'services/PokemonService.php';
require_once 'models/UserInteraction.php';

// Obtener ID del Pokémon
$pokemonId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($pokemonId <= 0) {
    header('Location: index.php');
    exit;
}

// Inicializar servicios
$pokemonService = new PokemonService();
$userInteraction = new UserInteraction(getDbConnection());

// Obtener detalles del Pokémon
$pokemon = $pokemonService->getPokemonDetailsById($pokemonId);

if (!$pokemon) {
    header('Location: index.php');
    exit;
}

// Establecer título de la página
$pageTitle = $pokemon->getCapitalizedName();

// Verificar si el Pokémon está marcado como "me gusta"
$isLiked = $userInteraction->isPokemonLiked($pokemon->id);

// Obtener comentarios
$comments = $userInteraction->getCommentsForPokemon($pokemon->id);

// Obtener color según el tipo principal
$mainType = $pokemon->types[0];
$mainColor = $pokemon->getTypeColor($mainType);

// Obtener información de la especie para la descripción
$speciesData = $pokemonService->getPokemonSpeciesById($pokemon->id);
$description = '';
if ($speciesData && isset($speciesData['flavor_text_entries'])) {
    foreach ($speciesData['flavor_text_entries'] as $entry) {
        if ($entry['language']['name'] === 'es') {
            $description = $entry['flavor_text'];
            break;
        }
    }
    // Si no hay descripción en español, usar la primera en inglés
    if (empty($description)) {
        foreach ($speciesData['flavor_text_entries'] as $entry) {
            if ($entry['language']['name'] === 'en') {
                $description = $entry['flavor_text'];
                break;
            }
        }
    }
}
?>

<div class="bg-white rounded-xl overflow-hidden shadow-lg mb-8">
    <div class="p-6" style="background: linear-gradient(135deg, <?= $mainColor ?> 0%, <?= adjustBrightness($mainColor, 30) ?> 100%);">
        <div class="container mx-auto">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 text-center">
                    <img src="<?= $pokemon->getDetailImageUrl() ?>" alt="<?= $pokemon->getCapitalizedName() ?>" 
                         class="max-h-64 mx-auto drop-shadow-lg">
                </div>
                <div class="md:w-1/2 text-white mt-6 md:mt-0">
                    <div class="flex justify-between items-center">
                        <h1 class="text-3xl font-bold"><?= $pokemon->getCapitalizedName() ?></h1>
                        <span class="text-2xl font-bold opacity-70"><?= $pokemon->getFormattedId() ?></span>
                    </div>
                    
                    <div class="mt-4 flex flex-wrap gap-2">
                        <?php foreach ($pokemon->types as $type): ?>
                            <span class="inline-block px-3 py-1 text-sm font-semibold text-white rounded-full" 
                                  style="background-color: <?= adjustBrightness($pokemon->getTypeColor($type), -20) ?>;">
                                <?= capitalizeFirst($type) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                    
                    <?php if (!empty($description)): ?>
                        <div class="mt-4 bg-white bg-opacity-20 p-4 rounded-lg">
                            <p><?= nl2br(htmlspecialchars($description)) ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mt-6 flex space-x-4">
                        <a href="index.php?action=like&id=<?= $pokemon->id ?>" 
                           class="inline-flex items-center px-4 py-2 bg-white text-<?= $isLiked ? 'red' : 'gray' ?>-700 rounded-lg hover:bg-gray-100">
                            <span class="mr-2"><?= $isLiked ? '❤' : '♡' ?></span>
                            <span>Me gusta</span>
                        </a>
                        
                        <a href="index.php?action=hide&id=<?= $pokemon->id ?>" 
                           class="inline-flex items-center px-4 py-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100">
                            <span class="mr-2">👁️</span>
                            <span>Ocultar</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-2xl font-bold mb-4">Características Físicas</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <div class="text-gray-500 mb-1">Altura</div>
                        <div class="font-bold"><?= ($pokemon->height / 10) ?> m</div>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <div class="text-gray-500 mb-1">Peso</div>
                        <div class="font-bold"><?= ($pokemon->weight / 10) ?> kg</div>
                    </div>
                    <div class="bg-gray-100 p-4 rounded-lg text-center">
                        <div class="text-gray-500 mb-1">Especie</div>
                        <div class="font-bold"><?= formatName($pokemon->species) ?></div>
                    </div>
                </div>
                
                <h2 class="text-2xl font-bold mt-8 mb-4">Habilidades</h2>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($pokemon->abilities as $ability): ?>
                        <span class="inline-block px-3 py-2 bg-gray-200 text-gray-800 rounded-lg">
                            <?= formatName($ability) ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div>
                <h2 class="text-2xl font-bold mb-4">Estadísticas Base</h2>
                <?php foreach ($pokemon->stats as $statName => $statValue): ?>
                    <?php include 'views/components/stat_bar.php'; ?>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="mt-12" id="comments">
            <h2 class="text-2xl font-bold mb-6">Comentarios</h2>
            <?php include 'views/components/comment_form.php'; ?>
        </div>
    </div>
</div>

<div class="text-center mt-8">
    <a href="index.php" class="inline-block px-6 py-3 bg-primary text-white font-medium rounded-lg hover:bg-red-600">
        Volver a la lista
    </a>
</div>
