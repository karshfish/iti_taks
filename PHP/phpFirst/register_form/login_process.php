<?php
session_start();
include 'db.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$errors = [];

if (empty($username)) {
    $errors['username'] = "Username is required.";
}

if (empty($password)) {
    $errors['password'] = "Password is required.";
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['old'] = $_POST;
    header("Location: login.php");
    exit;
}

try {
    $db = DB::connectWriteDB();
    $stmt = $db->prepare("SELECT id, username, password, first_name, last_name, photo 
                          FROM users 
                          WHERE username = :username LIMIT 1");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // success: store user in session
        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'],
            'photo' => $user['photo']
        ];
        header("Location: view.php");
        exit;
    } else {
        $errors['username'] = "Invalid username or password.";
        $_SESSION['errors'] = $errors;
        $_SESSION['old'] = $_POST;
        header("Location: login.php");
        exit;
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
