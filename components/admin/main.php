<?php

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: /");
    exit();
}

function getUsers() {
    global $conn;
    try {
        $query = $conn->prepare("SELECT id, email, firstName, lastName, is_admin FROM users");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

function updateUserDetails($userId, $email, $firstName, $lastName, $is_admin, $password = null) {
    global $conn;
    try {
        if ($password) {
            $query = $conn->prepare("UPDATE users SET email = ?, firstName = ?, lastName = ?, password = ?, is_admin = ? WHERE id = ?");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query->execute([$email, $firstName, $lastName, $hashedPassword, $is_admin, $userId]);
        } else {
            $query = $conn->prepare("UPDATE users SET email = ?, firstName = ?, lastName = ?, is_admin = ? WHERE id = ?");
            $query->execute([$email, $firstName, $lastName, $is_admin, $userId]);
        }
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

function deleteUser($userId) {
    global $conn;
    try {
        $query = $conn->prepare("DELETE FROM users WHERE id = ?");
        $query->execute([$userId]);
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

$users = getUsers();

include 'post.php';

?>

    <div class="container mt-5">
        <?php
        echo $_SESSION['message'] ?? '';
        unset($_SESSION['message']);
        ?>
        <h2 class="mb-4">Administration</h2>
        <?php include 'users_list.php'; ?>
    </div>

    <?php include 'modal.php'; ?>
    <script>
    var editUserModal = document.getElementById('editUserModal');
    editUserModal.addEventListener('show.bs.modal', function (event) {
        editUserModal.querySelector('#editUserId').value = event.relatedTarget.getAttribute('data-id');
        editUserModal.querySelector('#editEmail').value = event.relatedTarget.getAttribute('data-email');
        editUserModal.querySelector('#editFirstName').value = event.relatedTarget.getAttribute('data-firstname');
        editUserModal.querySelector('#editLastName').value = event.relatedTarget.getAttribute('data-lastname');
        editUserModal.querySelector('#editIsAdmin').checked = event.relatedTarget.getAttribute('data-isadmin') === '1';
    });
    </script>
