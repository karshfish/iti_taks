<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Simple Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4 class="card-title mb-4">Registration Form</h4>
                <form action="create_user.php" method="post">
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
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
                <a href="view.php" class="btn btn-primary mt-2">View Page</a>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>