<header class="d-flex align-items-center">
      <div class="container d-flex align-items-center justify-content-between">
            <a href="./" class="text-decoration-none">
                  <h3 class="text-white"><?= env("TITLE") ?></h3>
            </a>
            <div class="buttons-wrapper d-flex gap-3">
                  <?php if (isLoggedIn()): ?>
                        <?php if ($userRole == "admin"): ?>
                              <a href="#!" class="btn btn-primary">Dashboard</a>
                        <?php endif; ?>
                        <a href="./logout.php" class="btn btn-danger">Logout</a>
                  <?php else: ?>
                        <a href="./login.php" class="btn btn-success">Login</a>
                        <a href="./register.php" class="btn btn-primary">Register</a>
                  <?php endif; ?>
            </div>
      </div>
</header>