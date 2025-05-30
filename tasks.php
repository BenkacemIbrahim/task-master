<?php
require_once 'config.php';

function getTasks() {
    global $pdo;
    $stmt = $pdo->query('SELECT * FROM tasks ORDER BY created_at DESC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function addTask($task) {
    global $pdo;
    $stmt = $pdo->prepare('INSERT INTO tasks (text, completed, created_at) VALUES (?, 0, NOW())');
    $stmt->execute([$task]);
}

function deleteTask($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = ?');
    $stmt->execute([$id]);
}

function toggleTask($id) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE tasks SET completed = NOT completed, completed_at = CASE WHEN completed = 0 THEN NOW() ELSE NULL END WHERE id = ?');
    $stmt->execute([$id]);
}

function updateTask($id, $newText) {
    global $pdo;
    $stmt = $pdo->prepare('UPDATE tasks SET text = ? WHERE id = ?');
    $stmt->execute([$newText, $id]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    switch ($action) {
        case 'add':
            $task = trim($_POST['task']);
            if (!empty($task)) {
                addTask($task);
            }
            break;
        case 'delete':
            $id = $_POST['id'] ?? '';
            if ($id) {
                deleteTask($id);
            }
            break;
        case 'toggle':
            $id = $_POST['id'] ?? '';
            if ($id) {
                toggleTask($id);
            }
            break;
        case 'update':
            $id = $_POST['id'] ?? '';
            $newText = trim($_POST['newText'] ?? '');
            if ($id && !empty($newText)) {
                updateTask($id, $newText);
            }
            break;
    }
    header('Location: index.php');
    exit;
}
?>