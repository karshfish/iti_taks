<?php
$code = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 5);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

</head>

<body>
    <form method="POST" action="result.php">
        <div class="mb-3">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" name="firstName">

        </div>
        <div class="mb-3">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" name="lastName">

        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address">

        </div>
        <label class="block">
            <span class="text-gray-700">Country</span>
            <select name="Country"
                class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="USA">USA</option>
                <option value="Canada">Canada</option>
                <option value="Mexico">Mexico</option>
                <option value="Egypt">Egypt</option>
            </select>
        </label>
        <span>Gender</span>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="male" id="male">
            <label class="form-check-label" for="radioDefault1">
                male
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="female" id="female">
            <label class="form-check-label" for="radioDefault2">
                female
            </label>
        </div>
        <span>Skills</span>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="skills[]" value="php" id="php">
            <label class="form-check-label" for="php">
                PHP
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="skills[]" value="MySQL" id="MySQL">
            <label class="form-check-label" for="MySQL">
                MySQL
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="skills[]" value="Postgree" id="Postgree">
            <label class="form-check-label" for="Postgree">
                PostgreeSQL
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="skills[]" value="J2SE" id="J2SE">
            <label class="form-check-label" for="J2SE">
                J2SE
            </label>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" aria-describedby="usernameHelp">
            <div id="usernameHelp" class="form-text">We'll never share your username with anyone else.</div>
        </div>
        <div class="mb-3">
            <label for="pass" class="form-label">Password</label>
            <input type="password" class="form-control" name="pass" id="pass">
        </div>
        <div class="mb-3">
            <label for="depart" class="form-label">Department</label>
            <input type="text" value="OpenSource" name="depart" id="depart" readonly>
        </div>
        <div class="mb-3">
            <label for="verfication" class="form-label">Are you a human? Enter this code <?php echo $code; ?></label>
            <input type="text" name="user_code" id="verification">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>