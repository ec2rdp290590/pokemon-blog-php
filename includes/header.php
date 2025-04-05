<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . ' - ' . APP_NAME : APP_NAME ?></title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#E3350D',
                        secondary: '#30A7D7',
                    }
                },
                fontFamily: {
                    sans: ['Poppins', 'sans-serif'],
                }
            }
        }
    </script>
    
    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Estilos adicionales -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .pokemon-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .pokemon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-primary text-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <a href="index.php" class="text-2xl font-bold">Pokémon Blog</a>
                
                <nav>
                    <ul class="flex space-x-6">
                        <li><a href="index.php" class="hover:text-gray-200">Inicio</a></li>
                        <li><a href="index.php?page=blog" class="hover:text-gray-200">Blog</a></li>
                        <li><a href="index.php?page=about" class="hover:text-gray-200">Acerca de</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
    <main class="flex-grow container mx-auto px-4 py-8">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline"><?= $_SESSION['message'] ?></span>
            </div>
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
