<?php
session_start();
$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors'], $_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">Login</h4>
                <form action="login_process.php" method="post">

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text"
                            class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                            id="username" name="username"
                            value="<?= htmlspecialchars($old['username'] ?? '') ?>"
                            placeholder="Enter your username">
                        <?php if (isset($errors['username'])): ?>
                            <div class="invalid-feedback"><?= $errors['username'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                            class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                            id="password" name="password"
                            placeholder="Enter your password">
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary">Login</button>
                    <a href="index.php" class="btn btn-link">Register</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>