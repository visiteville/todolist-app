<?php
// Configuration DB
$host = 'db';
$user = 'todo';
$pass = 'todopass';
$dbname = 'tododb';

// Connexion DB
try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    
    if ($conn->connect_error) {
        throw new Exception("Connexion failed: " . $conn->connect_error);
    }
    
    // Traitement du formulaire
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['task'])) {
        $task = htmlspecialchars($_POST['task']);
        
        $stmt = $conn->prepare("INSERT INTO taches (task) VALUES (?)");
        $stmt->bind_param("s", $task);
        
        if ($stmt->execute()) {
            $message = "Tâche ajoutée avec succès!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    
    // Récupérer les tâches
    $result = $conn->query("SELECT * FROM taches ORDER BY created_at DESC");
    $tasks = $result->fetch_all(MYSQLI_ASSOC);
    
    $conn->close();
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>TodoList</title>
    <meta charset="UTF-8">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <h1 class="mb-4 text-center">Ma TodoList</h1>

        <?php if (isset($message)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form method="POST" class="d-flex mb-4">
            <input type="text" name="task" class="form-control me-2" placeholder="Nouvelle tâche" required>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>

        <ul class="list-group">
            <?php foreach ($tasks as $task): ?>
                <li class="list-group-item"><?= htmlspecialchars($task['task']) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Bootstrap JS (optionnel, pour certains composants) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>