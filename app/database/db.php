<?php
require "connect.php";
function insertMessage($pdo, $name, $email, $message) {
    $stmt = $pdo->prepare("INSERT INTO messages (client_name, client_email, message) VALUES (?, ?, ?)");
    $stmt->execute([$name, $email, $message]);
    return json_encode(['success' => true, 'message' => 'Message sent successfully']);
}

function fetchMessages($pdo) {
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY date DESC");
    $messages = $stmt->fetchAll();
    return json_encode($messages);
}

function deleteMessage($pdo, $id) {
    if (!empty($id)) {
        $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
        $stmt->execute([$id]);
        return json_encode(['success' => true, 'message' => 'Message deleted successfully']);
    } else {
        return json_encode(['success' => false, 'message' => 'Invalid ID']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        case 'insert':
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message = $_POST['message'] ?? '';
            echo insertMessage($pdo, $name, $email, $message);
            break;

        case 'fetch':
            echo fetchMessages($pdo);
            break;

        case 'delete':
            $id = $_POST['id'] ?? '';
            echo deleteMessage($pdo, $id);
            break;

        default:
            echo json_encode(['success' => false, 'message' => 'Unknown action']);
            break;
    }
}