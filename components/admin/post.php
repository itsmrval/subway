<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {
    if (isset($_POST['delete'])) {
        if ($_POST['userId'] == $_SESSION['user_id']) {
            echo 222;
            $_SESSION['message'] = '<div class="alert alert-danger text-center" role="alert">You cannot delete yourself.</div>';
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }
        $success = deleteUser($_POST['userId']);
        if ($success) {
            $_SESSION['message'] = '<div class="alert alert-success text-center" role="alert">User deleted successfully.</div>';
        } else {
            $_SESSION['message'] = '<div class="alert alert-danger text-center" role="alert">Failed to delete user.</div>';
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
    
    $password = !empty($_POST['password']) ? $_POST['password'] : null;
    $_POST['is_admin'] = isset($_POST['is_admin']) ? 1 : 0;
    

    $success = updateUserDetails($_POST['userId'], $_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['is_admin'], $password);

    if ($success) {
        $_SESSION['message'] = '<div class="alert alert-success text-center" role="alert">User updated successfully.</div>';
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger text-center" role="alert">Failed to update user.</div>';
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

?>