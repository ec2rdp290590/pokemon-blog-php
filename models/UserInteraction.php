<?php
class UserInteraction {
    private $conn;
    private $userId;
    
    public function __construct($conn) {
        $this->conn = $conn;
        
        // Usar ID de sesión como ID de usuario si no hay sistema de usuarios
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['user_id'] = session_id();
        }
        
        $this->userId = $_SESSION['user_id'];
    }
    
    // Verificar si un Pokémon está marcado como "me gusta"
    public function isPokemonLiked($pokemonId) {
        $stmt = $this->conn->prepare("SELECT id FROM pokemon_likes WHERE pokemon_id = ? AND user_id = ?");
        $stmt->bind_param("is", $pokemonId, $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
    
    // Alternar el estado de "me gusta" de un Pokémon
    public function toggleLike($pokemonId) {
        if ($this->isPokemonLiked($pokemonId)) {
            // Si ya tiene "me gusta", eliminarlo
            $stmt = $this->conn->prepare("DELETE FROM pokemon_likes WHERE pokemon_id = ? AND user_id = ?");
            $stmt->bind_param("is", $pokemonId, $this->userId);
            $stmt->execute();
            return false; // Ya no tiene "me gusta"
        } else {
            // Si no tiene "me gusta", agregarlo
            $stmt = $this->conn->prepare("INSERT INTO pokemon_likes (pokemon_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("is", $pokemonId, $this->userId);
            $stmt->execute();
            return true; // Ahora tiene "me gusta"
        }
    }
    
    // Verificar si un Pokémon está oculto
    public function isPokemonHidden($pokemonId) {
        $stmt = $this->conn->prepare("SELECT id FROM hidden_pokemon WHERE pokemon_id = ? AND user_id = ?");
        $stmt->bind_param("is", $pokemonId, $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
    
    // Ocultar un Pokémon
    public function hidePokemon($pokemonId) {
        if (!$this->isPokemonHidden($pokemonId)) {
            $stmt = $this->conn->prepare("INSERT INTO hidden_pokemon (pokemon_id, user_id) VALUES (?, ?)");
            $stmt->bind_param("is", $pokemonId, $this->userId);
            return $stmt->execute();
        }
        
        return false;
    }
    
    // Obtener comentarios para un Pokémon
    public function getCommentsForPokemon($pokemonId) {
        $stmt = $this->conn->prepare("SELECT id, user_id, username, comment, created_at FROM pokemon_comments WHERE pokemon_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $pokemonId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        
        return $comments;
    }
    
    // Agregar un comentario a un Pokémon
    public function addComment($pokemonId, $comment, $username) {
        $comment = trim($comment);
        $username = trim($username);
        
        if (empty($comment) || empty($username)) {
            return false;
        }
        
        $stmt = $this->conn->prepare("INSERT INTO pokemon_comments (pokemon_id, user_id, username, comment) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $pokemonId, $this->userId, $username, $comment);
        
        return $stmt->execute();
    }
    
    // Obtener todos los Pokémon con "me gusta"
    public function getLikedPokemonIds() {
        $stmt = $this->conn->prepare("SELECT pokemon_id FROM pokemon_likes WHERE user_id = ?");
        $stmt->bind_param("s", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $likedIds = [];
        while ($row = $result->fetch_assoc()) {
            $likedIds[] = $row['pokemon_id'];
        }
        
        return $likedIds;
    }
    
    // Obtener todos los Pokémon ocultos
    public function getHiddenPokemonIds() {
        $stmt = $this->conn->prepare("SELECT pokemon_id FROM hidden_pokemon WHERE user_id = ?");
        $stmt->bind_param("s", $this->userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $hiddenIds = [];
        while ($row = $result->fetch_assoc()) {
            $hiddenIds[] = $row['pokemon_id'];
        }
        
        return $hiddenIds;
    }
    
    // Contar "me gusta" para un Pokémon
    public function countLikesForPokemon($pokemonId) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM pokemon_likes WHERE pokemon_id = ?");
        $stmt->bind_param("i", $pokemonId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        return $row['count'];
    }
}
?>
