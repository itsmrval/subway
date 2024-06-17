<?php
session_start();
include __DIR__ . '/../config.php';
include __DIR__ . '/../services/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['stopId'], $_POST['lineId'], $_POST['action'])) {
    $userId = $_SESSION['user_id'];
    $stopId = $_POST['stopId'];
    $lineId = $_POST['lineId'];
    $action = $_POST['action'];

    try {
        if ($action === 'add') {
            $query = $conn->prepare("SELECT * FROM favorites WHERE userId = ? AND stopId = ? AND lineId = ?");
            $query->execute([$userId, $stopId, $lineId]);
            $existingFavorite = $query->fetch();

            if (!$existingFavorite) {
                $query = $conn->prepare("INSERT INTO favorites (userId, stopId, lineId) VALUES (?, ?, ?)");
                $query->execute([$userId, $stopId, $lineId]);
            }
        } elseif ($action === 'remove') {
            $query = $conn->prepare("DELETE FROM favorites WHERE userId = ? AND stopId = ? AND lineId = ?");
            $query->execute([$userId, $stopId, $lineId]);
        }
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit();
}
?>
