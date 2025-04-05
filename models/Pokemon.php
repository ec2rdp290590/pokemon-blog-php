<?php
class Pokemon {
    public $id;
    public $name;
    public $imageUrl;
    public $types = [];
    public $height;
    public $weight;
    public $abilities = [];
    public $stats = [];
    public $species;
    
    // Constructor para crear un objeto Pokémon desde datos JSON
    public function __construct($data = null) {
        if ($data) {
            $this->id = $data['id'];
            $this->name = $data['name'];
            $this->imageUrl = $data['sprites']['other']['official-artwork']['front_default'] ?? 
                             $data['sprites']['front_default'];
            $this->height = $data['height'];
            $this->weight = $data['weight'];
            $this->species = $data['species']['name'];
            
            // Extraer tipos
            foreach ($data['types'] as $type) {
                $this->types[] = $type['type']['name'];
            }
            
            // Extraer habilidades
            foreach ($data['abilities'] as $ability) {
                $this->abilities[] = $ability['ability']['name'];
            }
            
            // Extraer estadísticas
            foreach ($data['stats'] as $stat) {
                $this->stats[$stat['stat']['name']] = $stat['base_stat'];
            }
        }
    }
    
    // Obtener URL de imagen detallada
    public function getDetailImageUrl() {
        return "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/home/{$this->id}.png";
    }
    
    // Obtener ID formateado (por ejemplo, #001)
    public function getFormattedId() {
        return '#' . str_pad($this->id, 3, '0', STR_PAD_LEFT);
    }
    
    // Obtener nombre capitalizado
    public function getCapitalizedName() {
        return ucfirst($this->name);
    }
    
    // Obtener color de fondo según el tipo
    public function getTypeColor($type) {
        $colors = [
            'fire' => '#FF4422',
            'water' => '#3399FF',
            'grass' => '#77CC55',
            'electric' => '#FFCC33',
            'psychic' => '#FF5599',
            'ice' => '#66CCFF',
            'dragon' => '#7766EE',
            'dark' => '#775544',
            'fairy' => '#EE99EE',
            'normal' => '#AAAA99',
            'fighting' => '#BB5544',
            'flying' => '#8899FF',
            'poison' => '#AA5599',
            'ground' => '#DDBB55',
            'rock' => '#BBAA66',
            'bug' => '#AABB22',
            'ghost' => '#6666BB',
            'steel' => '#AAAABB'
        ];
        
        return $colors[$type] ?? '#999999';
    }
    
    // Obtener color para estadísticas
    public function getStatColor($statName) {
        $colors = [
            'hp' => '#FF0000',
            'attack' => '#F08030',
            'defense' => '#F8D030',
            'special-attack' => '#6890F0',
            'special-defense' => '#78C850',
            'speed' => '#F85888'
        ];
        
        return $colors[$statName] ?? '#A8A878';
    }
}
?>
