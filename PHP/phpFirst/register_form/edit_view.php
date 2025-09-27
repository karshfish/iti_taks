<?php
include 'db.php';
session_start();

$writeDB = DB::connectWriteDB();

// Get user by id
$user_id = $_GET['id'] ?? null;
if (!$user_id) {
    die("User ID missing.");
}

$stmt = $writeDB->prepare("SELECT u.*, GROUP_CONCAT(s.skill) as skills 
                           FROM users u
                           LEFT JOIN skills s ON u.id = s.user_id
                           WHERE u.id = :id
                           GROUP BY u.id");
$stmt->execute([':id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

$errors = [];
$old_skills = $user['skills'] ? explode(',', $user['skills']) : [];

// ===== Handle form submission =====
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = trim($_POST['firstName'] ?? '');
    $lastName  = trim($_POST['lastName'] ?? '');
    $address   = trim($_POST['address'] ?? '');
    $country   = $_POST['country'] ?? '';
    $username  = trim($_POST['username'] ?? '');
    $password  = $_POST['password'] ?? '';
    $skills    = $_POST['skills'] ?? [];
    $photoPath = $user['photo']; // keep old photo by default

    // --- Validation ---
    if (empty($firstName) || strlen($firstName) < 2) $errors['firstName'] = "First name too short.";
    if (empty($lastName) || strlen($lastName) < 2)   $errors['lastName'] = "Last name too short.";
    if (empty($username) || strlen($username) < 4)   $errors['username'] = "Username too short.";
    if (!empty($password) && strlen($password) < 6)  $errors['password'] = "Password must be at least 6 chars.";
    if (empty($country))                             $errors['country'] = "Please select a country.";

    // --- Handle new photo ---
    if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['photo']['type'], $allowed)) {
            $errors['photo'] = "Only JPG or PNG allowed.";
        } else {
            $uploadDir = "assets/img/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileName = uniqid() . "_" . basename($_FILES['photo']['name']);
            $destPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $destPath)) {
                // delete old photo
                if (!empty($user['photo']) && file_exists($user['photo'])) {
                    unlink($user['photo']);
                }
                $photoPath = $destPath;
            }
        }
    }

    // If no errors, update
    if (empty($errors)) {
        try {
            $hashedPassword = !empty($password)
                ? password_hash($password, PASSWORD_DEFAULT)
                : $user['password']; // keep old if not changed

            $update = $writeDB->prepare("UPDATE users SET 
                            first_name = :fn,
                            last_name = :ln,
                            address = :addr,
                            country = :country,
                            username = :username,
                            password = :pwd,
                            photo = :photo
                        WHERE id = :id");
            $update->execute([
                ':fn' => $firstName,
                ':ln' => $lastName,
                ':addr' => $address,
                ':country' => $country,
                ':username' => $username,
                ':pwd' => $hashedPassword,
                ':photo' => $photoPath,
                ':id' => $user_id
            ]);

            // Update skills
            $writeDB->prepare("DELETE FROM skills WHERE user_id = :id")->execute([':id' => $user_id]);
            $insertSkill = $writeDB->prepare("INSERT INTO skills (user_id, skill) VALUES (:id, :skill)");
            foreach ($skills as $skill) {
                $insertSkill->execute([':id' => $user_id, ':skill' => $skill]);
            }

            header("Location: view.php");
            exit;
        } catch (PDOException $e) {
            $errors['db'] = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container py-4">

    <h2>Edit User</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $field => $msg): ?>
                    <li><strong><?= ucfirst($field) ?>:</strong> <?= htmlspecialchars($msg) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="firstName" class="form-control" value="<?= htmlspecialchars($user['first_name']) ?>">
        </div>
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="lastName" class="form-control" value="<?= htmlspecialchars($user['last_name']) ?>">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($user['address']) ?>">
        </div>
        <div class="mb-3">
            <label>Country</label>
            <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($user['country']) ?>">
        </div>
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']) ?>">
        </div>
        <div class="mb-3">
            <label>Password (leave blank to keep old)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>Skills</label><br>
            <?php $allSkills = ['PHP', 'MySQL', 'JavaScript', 'Laravel', 'HTML', 'CSS']; ?>
            <?php foreach ($allSkills as $s): ?>
                <label class="me-2">
                    <input type="checkbox" name="skills[]" value="<?= $s ?>"
                        <?= in_array($s, $old_skills) ? 'checked' : '' ?>>
                    <?= $s ?>
                </label>
            <?php endforeach; ?>
        </div>
        <div class="mb-3">
            <label>Photo</label><br>
            <?php if (!empty($user['photo']) && file_exists($user['photo'])): ?>
                <img src="<?= $user['photo'] ?>" width="100" class="mb-2"><br>
            <?php endif; ?>
            <input type="file" name="photo" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="view.php" class="btn btn-secondary">Cancel</a>
    </form>

</body>

</html>