<?php

function getUserDetails($userId) {
    global $conn;
    try {
        $query = $conn->prepare("SELECT email, firstName, lastName FROM users WHERE id = ?");
        $query->execute([$userId]);
        return $query->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return null;
    }
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = updateUserDetails($_SESSION['user_id'], $_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['password']);

    if ($success) {
        $_SESSION['message'] = '<div class="alert alert-success text-center" role="alert">Account updated successfully.</div>';
    } else {
        $_SESSION['message'] = '<div class="alert alert-danger text-center" role="alert">Failed to update account.</div>';
    }

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

$userDetails = getUserDetails($_SESSION['user_id']);
?>

<div class="container mt-5">
    <?php
        echo $_SESSION['message'] ?? '';
        unset($_SESSION['message']);
    ?>
    <h2 class="mb-4">Edit Account</h2>
    <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($userDetails['email']); ?>" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="firstName" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($userDetails['firstName']); ?>" placeholder="Enter your first name" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($userDetails['lastName']); ?>" placeholder="Enter your last name" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter a new password">
                <small class="form-text text-muted">Leave blank if you do not want to change the password</small>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
<?php
$query = $conn->prepare("SELECT logs.ip, logs.date, users.email FROM logs JOIN users ON logs.userId = users.id");
$query->execute();
$logDetails = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<table class="table mt-4">
    <thead>
        <tr>
            <th>IP</th>
            <th>Date</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($logDetails as $log): ?>
            <tr>
                <td><?php echo $log['ip']; ?></td>
                <td><?php echo $log['date']; ?></td>
                <td><?php echo $log['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
