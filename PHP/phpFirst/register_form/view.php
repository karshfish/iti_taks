<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title">Users Table</h4>
                    <a href="index.php" class="btn btn-success">+ Add User</a>
                </div>

                <table class="table table-bordered table-striped text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Photo</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Skills</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Address</th>
                            <th>View</th>
                            <th>Delete</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once 'db.php';
                        try {
                            $readbd = DB::connectReadDB();
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }

                        try {
                            $users_stmt = "SELECT u.id, u.first_name, u.last_name, u.photo,
                                                  GROUP_CONCAT(s.skill SEPARATOR ', ') AS skills,
                                                  username, password, address
                                           FROM users u
                                           LEFT JOIN skills s ON u.id = s.user_id
                                           GROUP BY u.id, u.first_name, u.last_name, u.photo;";
                            $users = $readbd->prepare($users_stmt);
                            $users->execute();
                            $users_info = $users->fetchAll(PDO::FETCH_ASSOC);

                            foreach ($users_info as $user) {
                                echo "<tr>";
                                $id = $user['id'];

                                // Photo
                                $photo = !empty($user['photo']) ? htmlspecialchars($user['photo']) : '';
                                echo "<td><img src= '$photo' alt='User Photo' width='60' height='60' class='rounded-circle'></td>";

                                // First & Last Name
                                $firstName = htmlspecialchars($user['first_name'] ?? '');
                                echo "<td>$firstName</td>";

                                $lastName = htmlspecialchars($user['last_name'] ?? '');
                                echo "<td>$lastName</td>";

                                // Skills
                                $skills = htmlspecialchars($user['skills'] ?? '');
                                echo "<td>$skills</td>";

                                // Username
                                $username = htmlspecialchars($user['username'] ?? '');
                                echo "<td>$username</td>";

                                // Password 
                                $password = htmlspecialchars($user['password'] ?? '');
                                echo "<td>$password</td>";

                                // Address
                                $address = htmlspecialchars($user['address'] ?? '');
                                echo "<td>$address</td>";

                                // Actions
                                echo "<td><a href='view_user.php?id=$id' class='btn btn-primary btn-sm'>View</a></td>";
                                echo "<td><a href='delete.php?id=$id' class='btn btn-danger btn-sm'>Delete</a></td>";
                                echo "<td><a href='edit_view.php?id=$id' class='btn btn-warning btn-sm'>Edit</a></td>";
                                echo "</tr>";
                            }
                        } catch (PDOException $e) {
                            echo $e->getMessage();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>