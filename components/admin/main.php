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

$users = getUsers();

include 'post.php';

?>

    <div class="container mt-5">
        <?php
        echo $_SESSION['message'] ?? '';
        unset($_SESSION['message']);
        ?>
        <h2 class="mb-4">Administration</h2>
        <form method="POST">
            <button type="submit" name="refreshData" class="btn btn-primary">Refresh Data</button>
        </form>
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
