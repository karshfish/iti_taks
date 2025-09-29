<?php
include 'db.php';
session_start();

$user_id = trim($_POST['id'] ?? '');
if (!$user_id) {
    die("User ID missing.");
}

try {
    $db = DB::connectWriteDB();

    // Fetch existing user
    $user_stmt = "SELECT u.id, u.first_name, u.last_name, u.username, u.password, u.address, u.country, u.photo,
                        GROUP_CONCAT(s.skill SEPARATOR ', ') AS skills
                  FROM users u
                  LEFT JOIN skills s ON u.id = s.user_id
                  WHERE u.id=:id
                  GROUP BY u.id";
    $stmt = $db->prepare($user_stmt);
    $stmt->execute(['id' => $user_id]);
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user_info) {
        die("User not found.");
    }

    $old_skills = array_map('trim', explode(',', $user_info['skills'] ?? ''));
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        // --- Collect inputs ---
        $firstName = trim($_POST['firstName'] ?? '');
        $lastName  = trim($_POST['lastName'] ?? '');
        $address   = trim($_POST['address'] ?? '');
        $country   = $_POST['country'] ?? '';
        $username  = trim($_POST['username'] ?? '');
        $password  = $_POST['password'] ?? '';
        $skills    = $_POST['skills'] ?? [];
        $photoPath = $user_info['photo']; // keep old photo by default

        // --- Handle photo upload ---
        if (!empty($_FILES['photo']['name']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/img/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $fileTmpPath = $_FILES['photo']['tmp_name'];
            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $destPath = $uploadDir . $fileName;

            $allowed = ['image/jpeg', 'image/png'];
            if (!in_array($_FILES['photo']['type'], $allowed)) {
                $errors['photo'] = "Only JPG and PNG images are allowed.";
            } else {
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    // delete old photo if exists
                    if (!empty($user_info['photo']) && file_exists($user_info['photo'])) {
                        unlink($user_info['photo']);
                    }
                    $photoPath = $destPath;
                }
            }
        }

        // --- Validation ---
        if (empty($firstName) || strlen($firstName) < 2) $errors['firstName'] = "First name must be at least 2 characters.";
        if (empty($lastName)  || strlen($lastName) < 2) $errors['lastName']  = "Last name must be at least 2 characters.";
        if (empty($username)  || strlen($username) < 4) $errors['username'] = "Username must be at least 4 characters.";
        if (empty($password)  || strlen($password) < 6) $errors['password'] = "Password must be at least 6 characters.";
        if (empty($country))  $errors['country'] = "Please select a country.";

        // --- If errors, redirect back with session ---
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $_POST;
            $_SESSION['old_user_info'] = $user_info;
            $_SESSION['old_user_skills'] = $old_skills;
            header("Location: index.php");
            exit;
        }

        // --- If valid, update DB ---
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // ✅ Update user using helper
            DB::update(
                "users",
                ["first_name", "last_name", "address", "country", "username", "password", "photo"],
                [$firstName, $lastName, $address, $country, $username, $hashedPassword, $photoPath],
                ["id" => $user_id]
            );

            // ✅ Update skills using helpers
            DB::delete("skills", ["user_id" => $user_id]);
            foreach ($skills as $skill) {
                DB::create("skills", ["user_id", "skill"], [$user_id, $skill]);
            }

            header("Location: view.php");
            exit;
        } catch (PDOException $e) {
            $errors[] = $e->getMessage();
            $_SESSION['errors'] = $errors;
            header("Location: index.php");
            exit;
        }
    }
} catch (PDOException $e) {
    die($e->getMessage());
}
