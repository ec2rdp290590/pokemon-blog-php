    </main>
    
    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Pokémon Blog</h3>
                    <p class="text-gray-300">Un blog dedicado al mundo Pokémon, con información detallada sobre cada especie.</p>
                </div>
                <div class="text-right">
                    <p class="text-gray-300">Desarrollado por Jesús Montes</p>
                    <p class="text-gray-400">Versión <?= APP_VERSION ?></p>
                    <p class="text-gray-400 mt-2">Datos obtenidos de <a href="https://pokeapi.co/" class="text-blue-300 hover:underline" target="_blank">PokéAPI</a></p>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-6 pt-6 text-center text-gray-400">
                <p>&copy; <?= date('Y') ?> Pokémon Blog. Todos los derechos reservados.</p>
                <p class="mt-2 text-sm">Pokémon y todos los nombres relacionados son marcas registradas de Nintendo.</p>
            </div>
        </div>
    </footer>
</body>
</html>
