<div class="bg-gray-100 p-6 rounded-lg mb-8">
    <form action="index.php" method="POST" class="space-y-4">
        <input type="hidden" name="action" value="add_comment">
        <input type="hidden" name="pokemon_id" value="<?= $pokemon->id ?>">
        
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
            <input type="text" id="username" name="username" required
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
        </div>
        
        <div>
            <label for="comment" class="block text-sm font-medium text-gray-700 mb-1">Comentario</label>
            <textarea id="comment" name="comment" rows="3" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary"></textarea>
        </div>
        
        <div>
            <button type="submit" class="px-6 py-2 bg-primary text-white font-medium rounded-lg hover:bg-red-600">
                Publicar comentario
            </button>
        </div>
    </form>
</div>

<!-- Lista de comentarios -->
<div class="space-y-6">
    <?php if (empty($comments)): ?>
        <div class="text-center text-gray-500 italic py-8">
            <p>No hay comentarios todavía. ¡Sé el primero en comentar!</p>
        </div>
    <?php else: ?>
        <?php foreach ($comments as $comment): ?>
            <div class="bg-white p-4 rounded-lg shadow">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white"
                             style="background-color: <?= $mainColor ?>;">
                            <?= strtoupper(substr($comment['username'], 0, 1)) ?>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="flex items-center">
                            <h4 class="font-bold"><?= htmlspecialchars($comment['username']) ?></h4>
                            <span class="ml-2 text-sm text-gray-500"><?= formatDate($comment['created_at']) ?></span>
                        </div>
                        <p class="mt-1 text-gray-800"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
