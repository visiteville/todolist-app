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
</head>
<body>
    <h1>Ma TodoList</h1>
    
    <?php if (isset($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <input type="text" name="task" placeholder="Nouvelle tâche" required>
        <button type="submit">Ajouter</button>
    </form>
    
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li><?= htmlspecialchars($task['task']) ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>