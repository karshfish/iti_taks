<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$user_id = $_GET['id'] ?? null;
if (!$user_id) {
    die("User ID missing.");
}

try {
    // ✅ Use helper instead of manual query
    DB::delete("users", ["id" => $user_id]);

    // Also delete their skills (optional cleanup)
    DB::delete("skills", ["user_id" => $user_id]);

    header("Location: view.php");
    exit;
} catch (PDOException $e) {
    die("Error deleting user: " . $e->getMessage());
}
