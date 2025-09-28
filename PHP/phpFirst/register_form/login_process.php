<?php
session_start();
include 'db.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];

// validation
if ($username === '') {
    $errors['username'] = "Username is required.";
}
if ($password === '') {
    $errors['password'] = "Password is required.";
}

if ($errors) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
    header("Location: login.php");
    exit;
}

try {
    $db = DB::connectReadDB();
    $stmt = $db->prepare("
        SELECT id, username, password, first_name, last_name, photo 
        FROM users 
        WHERE username = :username 
        LIMIT 1
    ");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user'] = [
            'id'         => $user['id'],
            'username'   => $user['username'],
            'first_name' => $user['first_name'],
            'last_name'  => $user['last_name'],
            'photo'      => $user['photo']
        ];
        header("Location: view.php");
        exit;
    }

    // fail: invalid creds
    $errors['username'] = "Invalid username or password.";
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
    header("Location: login.php");
    exit;
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
