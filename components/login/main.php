<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $query = $conn->prepare("SELECT * FROM users WHERE email = :email");
  $query->bindParam(':email', $_POST['email']);
  $query->execute();
  $user = $query->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($_POST['password'], $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['is_admin'] = $user['is_admin'];
    header("Location: index.php");
  } else {
    $errorMessage = "Invalid email or password.";
  }
}

?>

<body class="text-center">
  <form class="form-signin" method="POST" action="login.php">
    <img class="mb-4" src="assets/logo/dark.png" alt="" width="256px">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <?= isset($errorMessage) ? '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>' : '' ?>
    <input type="email" id="email" name="email" class="form-control mt-2" placeholder="damien.dupuis@gmail.com" required autofocus>
    <input type="password" id="password" name="password" class="form-control mt-2" placeholder="Password" required>
  
    <button class="btn btn-lg btn-primary btn-block" type="submit">Continue</button>
    <p class="mt-5 mb-3 text-muted">Not registered ? <a class="text-decoration-none" href="/register.php">Create an account here</a></p>
  </form>
</body>
