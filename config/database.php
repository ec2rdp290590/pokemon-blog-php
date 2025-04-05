<?php
// Conexión a la base de datos
function getDbConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    $conn->set_charset("utf8mb4");
    return $conn;
}

// Inicializar la base de datos si no existe
function initializeDatabase() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
    
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
    
    // Crear la base de datos si no existe
    $sql = "CREATE DATABASE IF NOT EXISTS " . DB_NAME;
    if ($conn->query($sql) === FALSE) {
        die("Error al crear la base de datos: " . $conn->error);
    }
    
    $conn->select_db(DB_NAME);
    
    // Crear tabla de likes
    $sql = "CREATE TABLE IF NOT EXISTS pokemon_likes (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        pokemon_id INT(11) NOT NULL,
        user_id VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_like (pokemon_id, user_id)
    )";
    
    if ($conn->query($sql) === FALSE) {
        die("Error al crear la tabla pokemon_likes: " . $conn->error);
    }
    
    // Crear tabla de Pokémon ocultos
    $sql = "CREATE TABLE IF NOT EXISTS hidden_pokemon (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        pokemon_id INT(11) NOT NULL,
        user_id VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY unique_hidden (pokemon_id, user_id)
    )";
    
    if ($conn->query($sql) === FALSE) {
        die("Error al crear la tabla hidden_pokemon: " . $conn->error);
    }
    
    // Crear tabla de comentarios
    $sql = "CREATE TABLE IF NOT EXISTS pokemon_comments (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        pokemon_id INT(11) NOT NULL,
        user_id VARCHAR(255) NOT NULL,
        username VARCHAR(50) NOT NULL,
        comment TEXT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === FALSE) {
        die("Error al crear la tabla pokemon_comments: " . $conn->error);
    }
    
    // Crear tabla de artículos del blog
    $sql = "CREATE TABLE IF NOT EXISTS blog_posts (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        featured_pokemon_id INT(11),
        author VARCHAR(100) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    if ($conn->query($sql) === FALSE) {
        die("Error al crear la tabla blog_posts: " . $conn->error);
    }
    
    $conn->close();
}
?>
