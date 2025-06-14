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
<<<<<<< HEAD

    // Ajouter une tâche
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task']) && empty($_POST['id'])) {
        $task = htmlspecialchars($_POST['task']);
        $stmt = $conn->prepare("INSERT INTO taches (task) VALUES (?)");
        $stmt->bind_param("s", $task);
        if ($stmt->execute()) {
            $message = "Tâche ajoutée avec succès!";
        } else {
            $message = "Erreur: " . $stmt->error;
        }
        $stmt->close();
    }

    // Modifier une tâche
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'], $_POST['id']) && !empty($_POST['id'])) {
        $id = (int) $_POST['id'];
        $task = htmlspecialchars($_POST['task']);
        $stmt = $conn->prepare("UPDATE taches SET task = ? WHERE id = ?");
        $stmt->bind_param("si", $task, $id);
        if ($stmt->execute()) {
            $message = "Tâche modifiée avec succès!";
        } else {
            $message = "Erreur: " . $stmt->error;
        }
        $stmt->close();
    }

    // Supprimer une tâche
    if (isset($_GET['delete'])) {
        $id = (int) $_GET['delete'];
        $stmt = $conn->prepare("DELETE FROM taches WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Tâche supprimée.";
        } else {
            $message = "Erreur: " . $stmt->error;
        }
        $stmt->close();
    }

=======
    
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
    
>>>>>>> infrastructure
    // Récupérer les tâches
    $result = $conn->query("SELECT * FROM taches ORDER BY created_at DESC");
    $tasks = $result->fetch_all(MYSQLI_ASSOC);
    
<<<<<<< HEAD
    // Si on est en train d’éditer une tâche
    $editTask = null;
    if (isset($_GET['edit'])) {
        $id = (int) $_GET['edit'];
        $stmt = $conn->prepare("SELECT * FROM taches WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $editTask = $result->fetch_assoc();
        $stmt->close();
    }

=======
>>>>>>> infrastructure
    $conn->close();
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>
<<<<<<< HEAD

?>
=======
>>>>>>> infrastructure
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
<<<<<<< HEAD
            <input type="hidden" name="id" value="<?= $editTask['id'] ?? '' ?>">
            <input type="text" name="task" class="form-control me-2" placeholder="Nouvelle tâche" required value="<?= $editTask['task'] ?? '' ?>">
            <button type="submit" class="btn btn-<?= isset($editTask) ? 'warning' : 'primary' ?>">
                <?= isset($editTask) ? 'Modifier' : 'Ajouter' ?>
            </button>
=======
            <input type="text" name="task" class="form-control me-2" placeholder="Nouvelle tâche" required>
            <button type="submit" class="btn btn-primary">Ajouter</button>
>>>>>>> infrastructure
        </form>

        <ul class="list-group">
            <?php foreach ($tasks as $task): ?>
<<<<<<< HEAD
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?= htmlspecialchars($task['task']) ?>
                    <div>
                        <a href="?edit=<?= $task['id'] ?>" class="btn btn-sm btn-warning me-1">✏️</a>
                        <a href="?delete=<?= $task['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette tâche ?')">🗑️</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

=======
                <li class="list-group-item"><?= htmlspecialchars($task['task']) ?></li>
            <?php endforeach; ?>
        </ul>
>>>>>>> infrastructure
    </div>

    <!-- Bootstrap JS (optionnel, pour certains composants) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>