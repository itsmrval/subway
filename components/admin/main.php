<?php

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: /");
    exit();
}

function getUsers() {
    global $conn;
    try {
        $query = $conn->prepare("SELECT id, email, firstName, lastName FROM users");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return [];
    }
}

$users = getUsers();

function updateUserDetails($userId, $email, $firstName, $lastName, $password = null) {
    global $conn;
    try {
        if ($password) {
            $query = $conn->prepare("UPDATE users SET email = ?, firstName = ?, lastName = ?, password = ? WHERE id = ?");
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $query->execute([$email, $firstName, $lastName, $hashedPassword, $userId]);
        } else {
            $query = $conn->prepare("UPDATE users SET email = ?, firstName = ?, lastName = ? WHERE id = ?");
            $query->execute([$email, $firstName, $lastName, $userId]);
        }
        return true;
    } catch(PDOException $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    $success = updateUserDetails($_POST['userId'], $_POST['email'], $_POST['firstName'], $_POST['lastName'], $password);

    if ($success) {
        $_SESSION['message'] = '<div class="alert alert-success text-center" role="alert">User updated successfully.</div>';
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger text-center" role="alert">Failed to update user.</div>';
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

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
    });
    </script>
