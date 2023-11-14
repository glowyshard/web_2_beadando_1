<?php

class UserModel {
    // adatbázis helye
}

class UserController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function registerUser($username, $password) {
        
        return $this->model->registerUser($username, $password);
    }

    public function loginUser($username, $password) {
        
        return $this->model->loginUser($username, $password);
    }
}

$model = new UserModel();
$controller = new UserController($model);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        
        $username = $_POST['registerUsername'];
        $password = $_POST['registerPassword'];

        
        $registrationSuccessful = $controller->registerUser($username, $password);

        if ($registrationSuccessful) {
           
        } else {
           
        }
    } elseif (isset($_POST['login'])) {
        
        $username = $_POST['username'];
        $password = $_POST['password'];

        
        $loginSuccessful = $controller->loginUser($username, $password);

        if ($loginSuccessful) {
            
        } else {
            // Login failed, handle accordingly
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">    
</head>
<body>
    <?php require_once("header.php")?>

    <div class="container">
        <div class="center-form">
            <h2>Belépés - The Sweet Oven</h2>

            <div id="loginForm">
                <form method="post" action="" class="mb-3">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary">Login</button>
                </form>
            </div>

            <div id="registerForm" style="display: none;">
                
                <form method="post" action="" class="mb-3">
                    <div class="mb-3">
                        <label for="registerUsername" class="form-label">Username:</label>
                        <input type="text" class="form-control" id="registerUsername" name="registerUsername" required>
                    </div>
                    <div class="mb-3">
                        <label for="registerPassword" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="registerPassword" name="registerPassword" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                </form>
            </div>

            <button onclick="toggleForms()" class="btn btn-secondary">Switch to Register</button>
        </div>
    </div>

    <script>
        function toggleForms() {
            var loginForm = document.getElementById("loginForm");
            var registerForm = document.getElementById("registerForm");

            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
            }
        }
    </script>

</body>
</html>
