<?php
include_once "db.php";
try {
    $writedb = DB::connectWriteDB();
    $readdb = DB::connectReadDB();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $firstName = validateInput($_POST['firstName']) ?? null;
    $lastName  = validateInput($_POST['lastName']) ?? null;
    $address   = validateInput($_POST['address']) ?? null;
    $country   = validateInput($_POST['country']) ?? null;
    $username  = validateInput($_POST['username']) ?? null;
    $password  = validateInput($_POST['password']) ?? null;
    $skills = $_POST['skills'] ?? null;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $photoPath = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'assets/img/'; // create this folder if not exists
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
    $errors = [];

    // First name
    if (empty($firstName) || strlen($firstName) < 2) {
        $errors['firstName'] = "First name must be at least 2 characters.";
    }

    // Last name
    if (empty($lastName) || strlen($lastName) < 2) {
        $errors['lastName'] = "Last name must be at least 2 characters.";
    }

    // Username
    if (empty($username) || strlen($username) < 4) {
        $errors['username'] = "Username must be at least 4 characters.";
    }

    // Password
    if (empty($password) || strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters.";
    }

    // Country
    if (empty($country)) {
        $errors['country'] = "Please select a country.";
    }

    // Photo (if uploaded)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['image/jpeg', 'image/png'];
        if (!in_array($_FILES['photo']['type'], $allowed)) {
            $errors['photo'] = "Only JPG and PNG images are allowed.";
        }
    }
    if (!empty($errors)) {
        session_start();
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST; // keep old input values
        header("Location: index.php");
        exit;
    }
    try {
        $sql = "INSERT INTO users 
        (first_name, last_name, address, country, username, password,photo) 
        VALUES (:first_name, :last_name, :address, :country, :username, :password,:photo)";

        $stmt = $writedb->prepare($sql);

        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':address'    => $address,
            ':country'    => $country,
            ':username'   => $username,
            ':password'   => $hashedPassword,
            ':photo'      => $photoPath
        ]);
        $last_usere_id = $writedb->lastInsertId();
        $user_skills = "INSERT INTO skills (user_id,skill) VALUES (:user_id, :skill);";
        foreach ($skills as $skill) {
            $stmt = $writedb->prepare($user_skills);
            $stmt->execute([
                'user_id' => $last_usere_id,
                'skill' => $skill
            ]);
        }
        header('Location: login.php');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
function validateInput(string $data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data; // ✅ works if $data is always set
}
