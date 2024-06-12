<?php
session_start();
include '../services/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['stopId'], $_POST['lineId'], $_POST['action'])) {
    $userId = $_SESSION['user_id'];
    $stopId = $_POST['stopId'];
    $lineId = $_POST['lineId'];
    $action = $_POST['action'];

    try {
        if ($action === 'add') {
            $stmt = $conn->prepare("INSERT INTO favorites (userId, stopId, lineId) VALUES (?, ?, ?)");
            $stmt->execute([$userId, $stopId, $lineId]);
        } elseif ($action === 'remove') {
            $stmt = $conn->prepare("DELETE FROM favorites WHERE userId = ? AND stopId = ? AND lineId = ?");
            $stmt->execute([$userId, $stopId, $lineId]);
        }
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit();
}
?>
