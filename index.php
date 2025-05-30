<?php require_once 'tasks.php'; ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionnaire de Tâches</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-gradient-to-br from-blue-100 to-purple-100 min-h-screen flex flex-col">
    <header class="glass-effect fixed w-full z-10 animate-fadeIn">
        <nav class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="#" class="flex items-center space-x-2">
                    <div class="logo-icon w-10 h-10"></div>
                    <span class="logo-text text-3xl font-extrabold">TaskMaster</span>
                </a>
                <div class="hidden md:flex space-x-8">
                    <a href="#"
                        class="nav-link text-gray-700 hover:text-blue-600 transition duration-300 text-lg font-medium">Accueil</a>
                    <a href="#"
                        class="nav-link text-gray-700 hover:text-blue-600 transition duration-300 text-lg font-medium">À
                        propos</a>
                    <a href="#"
                        class="nav-link text-gray-700 hover:text-blue-600 transition duration-300 text-lg font-medium">Contact</a>
                </div>
                <button id="mobile-menu-button"
                    class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none transition duration-300">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
            <div id="mobile-menu" class="md:hidden hidden mt-4 animate-fadeIn">
                <a href="#" class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Accueil</a>
                <a href="#" class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">À propos</a>
                <a href="#" class="block py-2 text-gray-700 hover:text-blue-600 transition duration-300">Contact</a>
            </div>
        </nav>
    </header>

    <main class="flex-grow flex items-center justify-center p-4 mt-20">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-lg">
            <h1 class="text-3xl font-bold mb-6 text-center text-blue-600">Gestionnaire de Tâches</h1>
            <form method="POST" class="mb-6">
                <div class="flex">
                    <input type="text" name="task" placeholder="Entrez une nouvelle tâche" required
                        class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg">
                    <input type="hidden" name="action" value="add">
                    <button type="submit"
                        class="bg-blue-500 text-white px-6 py-2 rounded-r-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg font-semibold transition duration-300">
                        Ajouter
                    </button>
                </div>
            </form>

            <ul class="space-y-3">
                <?php foreach (getTasks() as $task): ?>
                <li class="flex items-center justify-between bg-gray-50 p-4 rounded-md shadow-sm transition duration-300 hover:shadow-md <?php echo $task['completed'] ? 'opacity-50' : ''; ?>"
                    data-id="<?php echo $task['id']; ?>">
                    <div class="flex items-center space-x-3 flex-grow">
                        <form method="POST" class="flex-shrink-0">
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                            <button type="submit" class="text-gray-400 hover:text-green-500 focus:outline-none">
                                <i
                                    class="fas <?php echo $task['completed'] ? 'fa-check-circle text-green-500' : 'fa-circle'; ?> text-xl"></i>
                            </button>
                        </form>
                        <span class="task-text <?php echo $task['completed'] ? 'line-through' : ''; ?>">
                            <?php echo htmlspecialchars($task['text']); ?>
                        </span>
                        <div class="task-edit-container hidden flex-grow">
                            <input type="text"
                                class="task-edit flex-grow px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
                                value="<?php echo htmlspecialchars($task['text']); ?>">
                            <button class="save-edit text-green-500 hover:text-green-700 ml-2">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="reset-edit text-yellow-500 hover:text-yellow-700 ml-2">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button class="close-edit text-red-500 hover:text-red-700 ml-2">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button
                            class="edit-task text-blue-400 hover:text-blue-600 focus:outline-none transition duration-300">
                            <i class="fas fa-edit"></i>
                        </button>
                        <form method="POST" class="flex-shrink-0">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                            <button type="submit"
                                class="text-red-400 hover:text-red-600 focus:outline-none transition duration-300">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </li>

                <?php endforeach; ?>
            </ul>

            <?php if (empty(getTasks())): ?>
            <p class="text-center text-gray-500 mt-6">Pas de tâches pour le moment. Ajoutez-en une ci-dessus !</p>
            <?php endif; ?>
        </div>
    </main>
    <footer class="glass-effect mt-12 py-8 animate-fadeIn">
        <div class="container mx-auto px-6">
            <div class="flex flex-wrap justify-between items-center">
                <div class="w-full md:w-1/3 text-center md:text-left mb-6 md:mb-0">
                    <div class="flex items-center justify-center md:justify-start space-x-2 mb-4">
                        <div class="logo-icon w-8 h-8"></div>
                        <h3 class="logo-text text-2xl font-extrabold">TaskMaster</h3>
                    </div>
                    <p class="text-gray-700">Simplifiez votre vie, une tâche à la fois.</p>
                </div>
                <div class="w-full md:w-1/3 text-center mb-6 md:mb-0">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Liens rapides</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-300">Accueil</a>
                        </li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-300">À propos</a>
                        </li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition duration-300">Contact</a>
                        </li>
                    </ul>
                </div>
                <div class="w-full md:w-1/3 text-center md:text-right">
                    <h4 class="text-lg font-semibold text-gray-700 mb-2">Suivez-nous</h4>
                    <div class="flex justify-center md:justify-end space-x-4">
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition duration-300"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition duration-300"><i
                                class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-600 hover:text-blue-600 transition duration-300"><i
                                class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-300 mt-8 pt-8 text-center text-gray-600">
                <p>&copy; 2024 TaskMaster. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="app.js"></script>
</body>

</html>