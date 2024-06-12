<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['password'] !== $_POST['confirmPassword']) {
        $errorMessage = "Password doesnt match";
    } else {
        $query = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $query->bindParam(':email', $_POST['email']);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $errorMessage = "Email already used.";
        }

        if (!isset($errorMessage)) {
            $query = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (:firstName, :lastName, :email, :password)");
            $query->bindParam(':firstName', $_POST['firstName']);
            $query->bindParam(':lastName', $_POST['lastName']);
            $query->bindParam(':email', $_POST['email']);
            $query->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
            $query->execute();

            header("Location: login.php");
            exit();
        }
    }

}
?>


<body class="text-center">
    <form class="form-signin" method="POST" action="register.php">
      <img src="assets/logo/dark.png" alt="" width="256px">
      <h1 class="h3 mb-3 font-weight-normal">Create an account</h1>
      <?= isset($errorMessage) ? '<div class="alert alert-danger" role="alert">' . $errorMessage . '</div>' : '' ?>

      <div class="row">
        <div class="col">
          <input type="text" id="firstName" name="firstName" class="form-control mt-2" placeholder="Damien" required>
        </div>
        <div class="col">
          <input type="text" id="lastName" name="lastName" class="form-control mt-2" placeholder="Dupuis" required>
        </div>
      </div>
      <input type="email" id="email" name="email" class="form-control mt-2" placeholder="damien.dupuis@gmail.com" required>
      <hr>
      <div class="row">
        <div class="col">
          <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col">
          <input type="password" id="confirmPassword" name="confirmPassword" class="form-control" placeholder="Confirmation" required>
        </div>
      </div>
    
      <button class="btn btn-lg btn-primary btn-block mt-4" type="submit">Continue</button>
      <p class="mt-5 mb-3 text-muted">Already an account ? <a class="text-decoration-none" href="/login.php">Login here</a></p>
    </form>
  </body>