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
                <h4 class="card-title mb-4">Users Table</h4>

                <table class="table table-bordered table-striped text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Skills</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Address</th>
                            <th>view</th>
                            <th>Dlete</th>
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
                            $users_stmt = "SELECT u.id, u.first_name, u.last_name, GROUP_CONCAT(s.skill SEPARATOR ', ') AS skills, username, password, address
                                                FROM users u
                                                LEFT JOIN skills s ON u.id = s.user_id
                                                GROUP BY u.id, u.first_name, u.last_name;";
                            $users = $readbd->prepare($users_stmt);
                            $users->execute();
                            $users_info = $users->fetchAll(PDO::FETCH_ASSOC);
                            // print_r($users_info);
                            foreach ($users_info as $user) {
                                echo "<tr>";
                                $id = $user['id'];
                                $firstName = $user['first_name'] ?? null;
                                echo "<td>$firstName</td>";
                                $lastName  = $user['last_name'] ?? null;
                                echo "<td>$lastName</td>";
                                $skills = $user['skills'] ?? null;
                                echo "<td>$skills</td>";
                                $username  = $user['username'] ?? null;
                                echo "<td>$username</td>";
                                $password  = $user['password'] ?? null;
                                echo "<td>$password</td>";
                                $address   = $user['address'] ?? null;
                                echo "<td>$address</td>";
                                echo "<td><a href='view_user.php?id=$id' class='btn btn-primary'>View</a></td>";
                                echo "<td><a href='delete.php?id=$id' class='btn btn-danger'>Delete</a></td>";
                                echo "<td><a href='edit.php?id=$id' class='btn btn-warning'>Edit</a></td>";
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