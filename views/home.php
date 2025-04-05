<?php
require_once 'services/PokemonService.php';
require_once 'models/UserInteraction.php';

// Establecer título de la página
$pageTitle = 'Inicio';

// Inicializar servicios
$pokemonService = new PokemonService();
$userInteraction = new UserInteraction(getDbConnection());

// Obtener parámetros de paginación
$page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
$offset = ($page - 1) * POKEMON_PER_PAGE;
$limit = POKEMON_PER_PAGE;

// Obtener lista de Pokémon
$pokemonUrls = $pokemonService->getPokemonList($offset, $limit);
$pokemonList = [];

// Obtener detalles de cada Pokémon
foreach ($pokemonUrls as $url) {  $limit);
$pokemonList = [];

// Obtener detalles de cada Pokémon
foreach ($pokemonUrls as $url) {
    $pokemon = $pokemonService->getPokemonDetailsByUrl($url);
    if ($pokemon && !$userInteraction->isPokemonHidden($pokemon->id)) {
        $pokemonList[] = $pokemon;
    }
}

// Obtener IDs de Pokémon con "me gusta"
$likedPokemonIds = $userInteraction->getLikedPokemonIds();
?>

<div class="mb-8">
    <h1 class="text-3xl font-bold mb-6 text-center">Explora el Mundo Pokémon</h1>
    
    <!-- Formulario de búsqueda -->
    <div class="max-w-md mx-auto mb-8">
        <form action="index.php" method="GET" class="flex">
            <input type="hidden" name="page" value="home">
            <input type="text" name="search" placeholder="Buscar Pokémon..." 
                   class="flex-grow px-4 py-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-primary"
                   value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-r-lg hover:bg-red-600">
                Buscar
            </button>
        </form>
    </div>
    
    <?php if (empty($pokemonList)): ?>
        <div class="text-center my-12">
            <h3 class="text-xl font-bold mb-4">No hay Pokémon para mostrar</h3>
            <p class="text-gray-600 mb-6">Todos los Pokémon están ocultos o ha ocurrido un error.</p>
            <a href="index.php" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-red-600">Refrescar</a>
        </div>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php foreach ($pokemonList as $pokemon): ?>
                <?php include 'views/components/pokemon_card.php'; ?>
            <?php endforeach; ?>
        </div>
        
        <!-- Paginación -->
        <div class="flex justify-center mt-8">
            <div class="inline-flex rounded-md shadow-sm">
                <?php if ($page > 1): ?>
                    <a href="<?= getPaginationUrl($page - 1) ?>" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50">
                        Anterior
                    </a>
                <?php endif; ?>
                
                <span class="px-4 py-2 text-sm font-medium text-white bg-primary border border-primary">
                    <?= $page ?>
                </span>
                
                <a href="<?= getPaginationUrl($page + 1) ?>" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50">
                    Siguiente
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
