<?php
// Establecer título de la página
$pageTitle = 'Blog';

// Obtener artículos del blog desde la base de datos
$conn = getDbConnection();
$stmt = $conn->prepare("SELECT * FROM blog_posts ORDER BY created_at DESC");
$stmt->execute();
$result = $stmt->get_result();

$blogPosts = [];
while ($row = $result->fetch_assoc()) {
    $blogPosts[] = $row;
}
?>

<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-center">Blog de Pokémon</h1>
    
    <?php if (empty($blogPosts)): ?>
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <h2 class="text-xl font-bold mb-4">No hay artículos disponibles</h2>
            <p class="text-gray-600 mb-4">Pronto publicaremos contenido interesante sobre el mundo Pokémon.</p>
            <p class="text-gray-600">¡Vuelve pronto!</p>
        </div>
    <?php else: ?>
        <div class="space-y-8">
            <?php foreach ($blogPosts as $post): ?>
                <article class="bg-white rounded-lg shadow-md overflow-hidden">
                    <?php if ($post['featured_pokemon_id']): ?>
                        <?php 
                        $pokemonService = new PokemonService();
                        $featuredPokemon = $pokemonService->getPokemonDetailsById($post['featured_pokemon_id']);
                        if ($featuredPokemon):
                            $mainType = $featuredPokemon->types[0];
                            $mainColor = $featuredPokemon->getTypeColor($mainType);
                        ?>
                            <div class="h-48 flex items-center justify-center" 
                                 style="background: linear-gradient(135deg, <?= $mainColor ?> 0%, <?= adjustBrightness($mainColor, 30) ?> 100%);">
                                <img src="<?= $featuredPokemon->imageUrl ?>" alt="<?= $featuredPokemon->getCapitalizedName() ?>" 
                                     class="h-32 object-contain">
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <h2 class="text-2xl font-bold mb-2"><?= htmlspecialchars($post['title']) ?></h2>
                        
                        <div class="flex items-center text-gray-500 text-sm mb-4">
                            <span>Por <?= htmlspecialchars($post['author']) ?></span>
                            <span class="mx-2">•</span>
                            <span><?= formatDate($post['created_at']) ?></span>
                        </div>
                        
                        <div class="prose max-w-none">
                            <?= nl2br(htmlspecialchars(substr($post['content'], 0, 300))) ?>...
                        </div>
                        
                        <div class="mt-4">
                            <a href="index.php?page=blog&post=<?= $post['id'] ?>" 
                               class="inline-block px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-red-600">
                                Leer más
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
