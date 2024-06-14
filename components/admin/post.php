<?php


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

function refreshData() {
    global $conn;
    try {

        $conn->exec("TRUNCATE TABLE stops");

        $json = @file_get_contents(__DIR__ .'/../../data/stops.json');
        $data = json_decode($json, true);

        $filteredData = array_filter($data, function($item) {
            return isset($item['fields']['mode']) && $item['fields']['mode'] === 'METRO';
        });
       
        $query = $conn->prepare("INSERT INTO stops (stopId, name, lineId) VALUES (?, ?, ?)");
        $conn->beginTransaction();
        foreach ($filteredData as $item) {
            $fields = $item['fields'];
            if (isset($fields['id_ref_zda'], $fields['nom_zda'], $fields['indice_lig'])) {
                try {
                    $query->execute([$fields['id_ref_zda'], $fields['nom_zda'], $fields['indice_lig']]);
                } catch (PDOException $e) {
                }
            }
        }

        $conn->commit();

        return true;
    } catch (Exception $e) {
        return false;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['refreshData'])) {
    $success = refreshData();
    if ($success) {
        $_SESSION['message'] = '<div class="alert alert-success text-center" role="alert">Data refreshed successfully.</div>';
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger text-center" role="alert">Failed to refresh data.</div>';
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userId'])) {


    if (isset($_POST['delete'])) {
        if ($_POST['userId'] == $_SESSION['user_id']) {
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