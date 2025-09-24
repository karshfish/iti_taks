<?php
include_once "db.php";
try {
    $writedb = DB::connectWriteDB();
    $readdb = DB::connectReadDB();
} catch (PDOException $e) {
    echo $e->getMessage();
}
if (isset($_POST)) {

    $firstName = $_POST['firstName'] ?? null;
    $lastName  = $_POST['lastName'] ?? null;
    $address   = $_POST['address'] ?? null;
    $country   = $_POST['country'] ?? null;
    $username  = $_POST['username'] ?? null;
    $password  = $_POST['password'] ?? null;
    $skills = $_POST['skills'] ?? null;
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    try {
        $sql = "INSERT INTO users 
        (first_name, last_name, address, country, username, password) 
        VALUES (:first_name, :last_name, :address, :country, :username, :password)";

        $stmt = $writedb->prepare($sql);

        $stmt->execute([
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':address'    => $address,
            ':country'    => $country,
            ':username'   => $username,
            ':password'   => $hashedPassword
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
        header('Location: index.php');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
