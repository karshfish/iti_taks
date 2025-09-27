<?php

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];

include 'db.php';
$user_id = $_GET['id'];
try {
    $writeDB = DB::connectWriteDB();
    $del_stmt = "DELETE FROM users WHERE id=:id";
    $deleted = $writeDB->prepare($del_stmt);
    $deleted->execute(['id' => $user_id]);
} catch (PDOException $e) {
    echo $e->getMessage();
}
header("Location: view.php");
