<?php
include 'db.php';
$user_id = $_GET['id'];
try {
    $writeDB = DB::connectWriteDB();
    $user_stmt = "SELECT u.id, u.first_name, u.last_name, GROUP_CONCAT(s.skill SEPARATOR ', ') AS skills, username, password, address,country
                                                FROM users u
                                                LEFT JOIN skills s ON u.id = s.user_id
                                                WHERE u.id=:id
                                                GROUP BY u.id, u.first_name, u.last_name;";
    $user = $writeDB->prepare($user_stmt);
    $user->execute(['id' => $user_id]);
    $user_info = $user->fetch(PDO::FETCH_ASSOC);
    // print_r($user_info);
} catch (PDOException $e) {
    $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">Edit user <?php echo $user_info['first_name'] ?></h4>
                <form action="" method="post">
                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter your first name">
                    </div>

                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter your last name">
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
                    </div>

                    <!-- Country -->
                    <div class="mb-3">
                        <label for="country" class="form-label">Country</label>
                        <select class="form-select" id="country" name="country">
                            <option selected disabled>Select your country</option>
                            <option value="Egypt">Egypt</option>
                            <option value="USA">USA</option>
                            <option value="Mexico">Mexico</option>
                            <option value="Canada">Canada</option>
                        </select>
                    </div>

                    <!-- Gender -->
                    <div class="mb-3">
                        <label class="form-label d-block">Gender</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="Male">
                            <label class="form-check-label" for="male">Male</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="Female">
                            <label class="form-check-label" for="female">Female</label>
                        </div>
                    </div>

                    <!-- Skills -->
                    <div class="mb-3">
                        <label class="form-label d-block">Skills</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="skills[]" value="PHP" id="php">
                            <label class="form-check-label" for="php">PHP</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="skills[]" value="MySQL" id="mysql">
                            <label class="form-check-label" for="mysql">MySQL</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="skills[]" value="Postgree" id="postgree">
                            <label class="form-check-label" for="postgree">Postgree</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="skills[]" value="J2SE" id="j2se">
                            <label class="form-check-label" for="j2se">J2SE</label>
                        </div>
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username">
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary">Edit</button>
                </form>
                <a href="view.php" class="btn btn-primary mt-2">View Page</a>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    $firstName = $_POST['firstName'] ?? null;
    $lastName  = $_POST['lastName'] ?? null;
    $address   = $_POST['address'] ?? null;
    $country   = $_POST['country'] ?? null;
    $username  = $_POST['username'] ?? null;
    $password  = $_POST['password'] ?? null;
    $skills = $_POST['skills'] ?? null;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    try {
        $sql = "UPDATE users SET 
        first_name = :first_name,
        last_name = :last_name,
        address = :address,
        country = :country,
        username = :username,
        password = :password
        WHERE id = :id;";

        $stmt = $writeDB->prepare($sql);

        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':address'    => $address,
            ':country'    => $country,
            ':username'   => $username,
            ':password'   => $hashedPassword,
            'id' => $user_id
        ]);
        $last_usere_id = $writeDB->lastInsertId();
        $user_skills = "UPDATE skills
                        SET skill = :skill
                        WHERE user_id = :id;";
        foreach ($skills as $skill) {
            $stmt = $writeDB->prepare($user_skills);
            $stmt->execute([
                'user_id' => $last_usere_id,
                'skill' => $skill
            ]);
        }
        header('Location: view.php');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
