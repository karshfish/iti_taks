<?php
include 'db.php';
$user_id = trim($_POST['id'] ?? '');
try {
    $writeDB = DB::connectWriteDB();

    // Fetch existing user
    $user_stmt = "SELECT u.id, u.first_name, u.last_name, u.username, u.password, u.address, u.country, u.photo,
                        GROUP_CONCAT(s.skill SEPARATOR ', ') AS skills
                  FROM users u
                  LEFT JOIN skills s ON u.id = s.user_id
                  WHERE u.id=:id
                  GROUP BY u.id";
    $stmt = $writeDB->prepare($user_stmt);
    $stmt->execute(['id' => $user_id]);
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
    $old_skills = array_map('trim', explode(',', $user_info['skills'] ?? ''));
    $errors = [];

    if ($_SERVER["REQUEST_METHOD"] === 'POST') {
        // Validation

        $firstName = trim($_POST['firstName'] ?? '');
        $lastName  = trim($_POST['lastName'] ?? '');
        $address   = trim($_POST['address'] ?? '');
        $country   = $_POST['country'] ?? '';
        $username  = trim($_POST['username'] ?? '');
        $password  = $_POST['password'] ?? '';
        $skills    = $_POST['skills'] ?? [];
        $photo     = $_FILES['photo'] ?? null;
        $errors = [];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $photoPath = $user_info['photo']; // keep old photo by default

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'assets/img/'; // create this folder if not exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $fileTmpPath = $_FILES['photo']['tmp_name'];
            $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
            $destPath = $uploadDir . $fileName;

            $allowed = ['image/jpeg', 'image/png'];
            if (!in_array($_FILES['photo']['type'], $allowed)) {
                $errors['photo'] = "Only JPG and PNG images are allowed.";
            } else {
                if (move_uploaded_file($fileTmpPath, $destPath)) {
                    // delete old photo if exists
                    if (!empty($user_info['photo']) && file_exists($user_info['photo'])) {
                        unlink($user_info['photo']);
                    }
                    $photoPath = $destPath;
                }
            }
        }


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
            $_SESSION['old_input'] = $_POST; // keep old input values
            $_SESSION['old_user_info'] = $user_info;
            $_SESSION['old_user_skills'] = $old_skills;

            header("Location: index.php");
            exit;
        }

        if (empty($errors)) {
            try {
                $sql = "UPDATE users SET 
                            first_name = :first_name,
                            last_name = :last_name,
                            address = :address,
                            country = :country,
                            username = :username,
                            password = :password,
                            photo = :photo
                        WHERE id = :id;";
                $stmt = $writeDB->prepare($sql);
                $stmt->execute([
                    ':first_name' => $firstName,
                    ':last_name'  => $lastName,
                    ':address'    => $address,
                    ':country'    => $country,
                    ':username'   => $username,
                    ':password'   => $hashedPassword,
                    ':photo'      => $photoPath,
                    ':id'         => $user_id
                ]);

                // Update skills
                $deleteSkills = $writeDB->prepare("DELETE FROM skills WHERE user_id = :id");
                $deleteSkills->execute([':id' => $user_id]);

                $insertSkill = $writeDB->prepare("INSERT INTO skills (user_id, skill) VALUES (:id, :skill)");
                foreach ($skills as $skill) {
                    $insertSkill->execute([':id' => $user_id, ':skill' => $skill]);
                }

                header("Location: view.php");
                exit;
            } catch (PDOException $e) {
                $errors[] = $e->getMessage();
            }
        }

        header("Location: view.php");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    die($e->getMessage());
}
