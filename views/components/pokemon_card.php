<?php
// Verificar si el Pokémon está marcado como "me gusta"
$isLiked = in_array($pokemon->id, $likedPokemonIds);

// Obtener color principal según el tipo principal
$mainType = $pokemon->types[0];
$mainColor = $pokemon->getTypeColor($mainType);
?>

<div class="pokemon-card bg-white rounded-xl overflow-hidden shadow-lg">
    <div class="h-40 flex items-center justify-center relative" style="background: linear-gradient(135deg, <?= $mainColor ?> 0%, <?= adjustBrightness($mainColor, 30) ?> 100%);">
        <div class="absolute top-2 right-3 text-white opacity-70 font-bold">
            <?= $pokemon->getFormattedId() ?>
        </div>
        <a href="index.php?page=pokemon&id=<?= $pokemon->id ?>" class="block">
            <img src="<?= $pokemon->imageUrl ?>" alt="<?= $pokemon->getCapitalizedName() ?>" 
                 class="h-32 w-auto object-contain transition-transform hover:scale-110">
        </a>
    </div>
    
    <div class="p-4">
        <h2 class="text-lg font-bold mb-2"><?= $pokemon->getCapitalizedName() ?></h2>
        
        <div class="flex justify-between items-center">
            <div class="flex flex-wrap gap-1">
                <?php foreach ($pokemon->types as $type): ?>
                    <span class="inline-block px-2 py-1 text-xs font-semibold text-white rounded-full" 
                          style="background-color: <?= $pokemon->getTypeColor($type) ?>;">
                        <?= capitalizeFirst($type) ?>
                    </span>
                <?php endforeach; ?>
            </div>
            
            <div class="flex items-center">
                <a href="index.php?action=like&id=<?= $pokemon->id ?>" class="text-2xl">
                    <?php if ($isLiked): ?>
                        <span class="text-red-500">❤</span>
                    <?php else: ?>
                        <span class="text-gray-400 hover:text-red-500">♡</span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
        
        <div class="mt-4 flex justify-between">
            <a href="index.php?page=pokemon&id=<?= $pokemon->id ?>" 
               class="inline-block px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-red-600">
                Ver detalles
            </a>
            
            <a href="index.php?action=hide&id=<?= $pokemon->id ?>" 
               class="inline-block px-3 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300"
               title="Ocultar Pokémon">
                Ocultar
            </a>
        </div>
    </div>
</div>
