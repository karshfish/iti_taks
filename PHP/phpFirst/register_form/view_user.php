<?php
include_once 'db.php';

session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
try {
    $readDB = DB::connectReadDB();
} catch (PDOException $e) {
    echo $e->getMessage();
}
$user_id = $_GET['id'];
try {
    $user_stmt = "SELECT 
    u.id, 
    u.first_name, 
    u.last_name, 
    u.username, 
    u.password, 
    u.address, 
    GROUP_CONCAT(s.skill SEPARATOR ', ') AS skills
FROM users u
LEFT JOIN skills s ON u.id = s.user_id
WHERE u.id=:id
GROUP BY u.id;";
    $user = $readDB->prepare($user_stmt);
    $user->execute(['id' => $user_id]);
    $user_info = $user->fetch(PDO::FETCH_ASSOC);
    // print_r($user_info);
} catch (PDOException $e) {
    echo $e->getMessage();
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Info</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow-lg border-0 rounded-3">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="mb-0">User Information</h3>
                    </div>
                    <div class="card-body">

                        <p><strong>First Name:</strong> <?php echo ($user_info['first_name']); ?></p>
                        <p><strong>Last Name:</strong> <?php echo $user_info['last_name']; ?></p>
                        <p><strong>Username:</strong> <?php echo $user_info['username']; ?></p>
                        <p><strong>Address:</strong> <?php echo $user_info['address']; ?></p>
                        <p><strong>Skills:</strong><?php echo $user_info['skills'] ?? null; ?></p>

                    </div>
                    <div class="card-footer text-center">
                        <a href="edit.php?id=<?php echo $user_id ?>" class="btn btn-warning">Edit</a>
                        <a href="delete.php?id=<?php echo $user_id ?>" class="btn btn-danger">Delete</a>
                        <a href="view.php" class="btn btn-primary">View All Users</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS (optional, for interactivity) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>