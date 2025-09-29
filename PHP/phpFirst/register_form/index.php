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
    <title>Simple Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">Registration Form</h4>
                <form action="create_user.php" method="post" enctype="multipart/form-data">

                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text"
                            class="form-control <?= isset($errors['firstName']) ? 'is-invalid' : '' ?>"
                            id="firstName" name="firstName"
                            value="<?= htmlspecialchars($old['firstName'] ?? '') ?>"
                            placeholder="Enter your first name">
                        <?php if (isset($errors['firstName'])): ?>
                            <div class="text-danger"><?= $errors['firstName'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text"
                            class="form-control <?= isset($errors['lastName']) ? 'is-invalid' : '' ?>"
                            id="lastName" name="lastName"
                            value="<?= htmlspecialchars($old['lastName'] ?? '') ?>"
                            placeholder="Enter your last name">
                        <?php if (isset($errors['lastName'])): ?>
                            <div class="text-danger"><?= $errors['lastName'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text"
                            class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
                            id="address" name="address"
                            value="<?= htmlspecialchars($old['address'] ?? '') ?>"
                            placeholder="Enter your address">
                        <?php if (isset($errors['address'])): ?>
                            <div class="text-danger"><?= $errors['address'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Country -->
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-select <?= isset($errors['country']) ? 'is-invalid' : '' ?>"
                            id="country" name="country">
                            <option disabled <?= empty($old['country']) ? 'selected' : '' ?>>Select your country</option>
                            <?php foreach (['Egypt', 'USA', 'Mexico', 'Canada'] as $c): ?>
                                <option value="<?= $c ?>" <?= ($old['country'] ?? '') === $c ? 'selected' : '' ?>><?= $c ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['country'])): ?>
                            <div class="text-danger"><?= $errors['country'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label class="form-label d-block">Gender</label>
                        <?php foreach (['Male', 'Female'] as $g): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender"
                                    id="<?= strtolower($g) ?>" value="<?= $g ?>"
                                    <?= ($old['gender'] ?? '') === $g ? 'checked' : '' ?>>
                                <label class="form-check-label" for="<?= strtolower($g) ?>"><?= $g ?></label>
                            </div>
                        <?php endforeach; ?>
                        <?php if (isset($errors['gender'])): ?>
                            <div class="text-danger"><?= $errors['gender'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Skills -->
                    <div class="mb-3">
                        <label class="form-label d-block">Skills</label>
                        <?php foreach (['PHP', 'MySQL', 'Postgree', 'J2SE'] as $s): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="skills[]"
                                    value="<?= $s ?>" id="<?= strtolower($s) ?>"
                                    <?= (isset($old['skills']) && in_array($s, $old['skills'])) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="<?= strtolower($s) ?>"><?= $s ?></label>
                            </div>
                        <?php endforeach; ?>
                        <?php if (isset($errors['skills'])): ?>
                            <div class="text-danger"><?= $errors['skills'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text"
                            class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>"
                            id="username" name="username"
                            value="<?= htmlspecialchars($old['username'] ?? '') ?>"
                            placeholder="Choose a username">
                        <?php if (isset($errors['username'])): ?>
                            <div class="text-danger"><?= $errors['username'] ?></div>
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
                            <div class="text-danger"><?= $errors['password'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Photo -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">Upload Photo</label>
                        <input type="file"
                            class="form-control <?= isset($errors['photo']) ? 'is-invalid' : '' ?>"
                            id="photo" name="photo" accept="assets/img/*">
                        <?php if (isset($errors['photo'])): ?>
                            <div class="text-danger"><?= $errors['photo'] ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <a href="login.php" class="btn btn-secondary mt-2">Already has an account</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>