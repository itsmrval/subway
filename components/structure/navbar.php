<?php if (isset($_SESSION['user_id'])) : ?>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="/">
          <img src="assets/logo/dark.png" alt="" width="64">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/') ? 'active' : ''; ?>" href="/">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/navigate.php') ? 'active' : ''; ?>" href="/navigate.php">Discover</a>
            </li>
            <li class="nav-item">
            <a class="nav-link <?php echo ($_SERVER['REQUEST_URI'] == '/account.php') ? 'active' : ''; ?>" href="/account.php">Account</a>
            </li>
          </ul>
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
              <a class="nav-link" href="/logout.php"><i class="fa fa-sign-out"></i></a>
            </li>
          </ul>
          <div class="d-flex">
              <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                  <a class="btn btn-primary" href="/admin.php">Admin</a>
              <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>
  </header>
<?php endif; ?>
