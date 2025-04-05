<?php
require_once 'models/Pokemon.php';

class PokemonService {
    private $baseUrl;
    
    public function __construct() {
        $this->baseUrl = POKEAPI_BASE_URL;
    }
    
    // Obtener lista de Pokémon con paginación
    public function getPokemonList($offset = 0, $limit = 20) {
        $url = "{$this->baseUrl}/pokemon?offset={$offset}&limit={$limit}";
        $response = $this->makeApiRequest($url);
        
        if (!$response) {
            return [];
        }
        
        $pokemonUrls = [];
        foreach ($response['results'] as $pokemon) {
            $pokemonUrls[] = $pokemon['url'];
        }
        
        return $pokemonUrls;
    }
    
    // Obtener detalles de un Pokémon por URL
    public function getPokemonDetailsByUrl($url) {
        $data = $this->makeApiRequest($url);
        
        if (!$data) {
            return null;
        }
        
        return new Pokemon($data);
    }
    
    // Obtener detalles de un Pokémon por ID
    public function getPokemonDetailsById($id) {
        $url = "{$this->baseUrl}/pokemon/{$id}";
        $data = $this->makeApiRequest($url);
        
        if (!$data) {
            return null;
        }
        
        return new Pokemon($data);
    }
    
    // Buscar Pokémon por nombre
    public function searchPokemonByName($name) {
        $name = strtolower(trim($name));
        if (empty($name)) {
            return [];
        }
        
        // La API de Pokémon no tiene búsqueda por nombre parcial, así que obtenemos una lista grande
        // y filtramos manualmente
        $url = "{$this->baseUrl}/pokemon?limit=100";
        $response = $this->makeApiRequest($url);
        
        if (!$response || !isset($response['results'])) {
            return [];
        }
        
        $matchingPokemon = [];
        foreach ($response['results'] as $pokemon) {
            if (strpos($pokemon['name'], $name) !== false) {
                $matchingPokemon[] = $pokemon['url'];
            }
        }
        
        return $matchingPokemon;
    }
    
    // Obtener especies de Pokémon por ID
    public function getPokemonSpeciesById($id) {
        $url = "{$this->baseUrl}/pokemon-species/{$id}";
        return $this->makeApiRequest($url);
    }
    
    // Realizar solicitud a la API
    private function makeApiRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            error_log('Error en la solicitud cURL: ' . curl_error($ch));
            curl_close($ch);
            return null;
        }
        
        curl_close($ch);
        
        return json_decode($response, true);
    }
}
?>
