<?php
// Valor máximo para estadísticas de Pokémon
$maxStatValue = 255;

// Calcular porcentaje para la barra de progreso
$percentage = ($statValue / $maxStatValue) * 100;

// Obtener color para la estadística
$statColor = $pokemon->getStatColor($statName);
?>

<div class="mb-4">
    <div class="flex justify-between mb-1">
        <span class="font-medium"><?= getStatName($statName) ?></span>
        <span class="font-medium"><?= $statValue ?></span>
    </div>
    <div class="w-full bg-gray-200 rounded-full h-2.5">
        <div class="h-2.5 rounded-full" 
             style="width: <?= $percentage ?>%; background-color: <?= $statColor ?>;">
        </div>
    </div>
</div>
