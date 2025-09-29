<?php
include_once "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = validateInput($_POST['firstName']) ?? null;
    $lastName  = validateInput($_POST['lastName']) ?? null;
    $address   = validateInput($_POST['address']) ?? null;
    $country   = validateInput($_POST['country']) ?? null;
    $username  = validateInput($_POST['username']) ?? null;
    $password  = validateInput($_POST['password']) ?? null;
    $skills    = $_POST['skills'] ?? [];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $photoPath = null;

    // 🔹 Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/img/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
        $destPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $photoPath = $destPath;
        }
    }

    // 🔹 Validate
    $errors = [];
    if (empty($firstName) || strlen($firstName) < 2) $errors['firstName'] = "First name must be at least 2 characters.";
    if (empty($lastName)  || strlen($lastName)  < 2) $errors['lastName']  = "Last name must be at least 2 characters.";
    if (empty($username)  || strlen($username) < 4) $errors['username']  = "Username must be at least 4 characters.";
    if (empty($password)  || strlen($password) < 6) $errors['password']  = "Password must be at least 6 characters.";
    if (empty($country)) $errors['country'] = "Please select a country.";
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['photo']['type'], $allowed)) {
            $errors['photo'] = "Only JPG and PNG images are allowed.";
        }
    }

    if (!empty($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: index.php");
        exit;
    }

    try {
        // 🔹 Insert user
        $lastUserId = DB::create("users", [
            "first_name" => $firstName,
            "last_name"  => $lastName,
            "address"    => $address,
            "country"    => $country,
            "username"   => $username,
            "password"   => $hashedPassword,
            "photo"      => $photoPath
        ]);

        // 🔹 Insert skills
        foreach ($skills as $skill) {
            DB::create("skills", [
                "user_id" => $lastUserId,
                "skill"   => $skill
            ]);
        }

        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function validateInput(string $data): string
{
    return htmlspecialchars(stripslashes(trim($data)));
}
