<?php
require_once('config.inc.php');

class UserModel {
    private $conn;

    public function __construct() {
            $host = 'mysql.omega';
			$port = '3306'
        $username = 'beadando1adatb';
        $password = 'adatb14r235235235234235r235234245r2534253242362354';
        $database = 'beadando1adatb';

        // Create connection
        $this->conn = new mysqli($host, $username, $password, $database, $port);

        // Check connection
        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function registerUser($username, $password, $keresztnev, $vezeteknev) {
        
        if ($this->isUsernameTaken($username)) {
          
            echo "<script>alert('Username is already taken. Please choose a different username.');</script>";
            return false;
        }

       
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("INSERT INTO users (username, password, keresztnev, vezeteknev) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashedPassword, $keresztnev, $vezeteknev);

        $result = $stmt->execute();

        $stmt->close();

        return $result;
    }

    private function isUsernameTaken($username) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();

        
        return $count > 0;
    }

    public function loginUser($username, $password) {
        $stmt = $this->conn->prepare("SELECT id, username, password, keresztnev, vezeteknev FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($id, $username, $hashedPassword, $keresztnev, $vezeteknev);
        $stmt->fetch();
        $stmt->close();

        if ($hashedPassword !== null && password_verify($password, $hashedPassword)) {
            
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $id;
            $_SESSION['login_name'] = $username;
            $_SESSION['family_name'] = $keresztnev;
            $_SESSION['surname'] = $vezeteknev;

            return true; 
        } else {
            return false; 
        }
    }

    public function logoutUser() {
       
        $_SESSION = array();

      
        session_destroy();
    }
}

class UserController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function registerUser($username, $password, $keresztnev, $vezeteknev) {
        return $this->model->registerUser($username, $password, $keresztnev, $vezeteknev);
    }

    public function loginUser($username, $password) {
        return $this->model->loginUser($username, $password);
    }

    public function logoutUser() {
        $this->model->logoutUser();
    }
}

$model = new UserModel();
$controller = new UserController($model);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $username = $_POST['registerUsername'];
        $password = $_POST['registerPassword'];
        $keresztnev = $_POST['keresztnev'];
        $vezeteknev = $_POST['vezeteknev'];

        $registrationSuccessful = $controller->registerUser($username, $password, $keresztnev, $vezeteknev);

        if ($registrationSuccessful) {
       
            echo "<script>switchToLogin(); showLoginSuccessPopup();</script>";
        } else {
            
        }
    } elseif (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $loginSuccessful = $controller->loginUser($username, $password);

        if ($loginSuccessful) {
        
            echo "<script>
                    alert('Login successful!');
                    window.location.href = '/web_2_beadando_1-main/index.php';
                  </script>";
        } else {
          
            echo "<script>alert('Login failed!');</script>";
       
            echo "<script>
                    setTimeout(function(){
                        window.location.href = '/web_2_beadando_1-main/fiok.php';
                    }, 2000); // 2000 milliseconds (2 seconds) delay
                  </script>";
        }
        
    } elseif (isset($_POST['logout'])) {
        
        $controller->logoutUser();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">   
    <title>Login</title> 
</head>
<body>
    <?php require_once("header.php")?>

        <div class="center-form">
            <h4>Belépés - The Sweet Oven</h4>

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
                    <div class="mb-3">
                        <label for="keresztnev" class="form-label">Keresztnév:</label>
                        <input type="text" class="form-control" id="keresztnev" name="keresztnev" required>
                    </div>
                    <div class="mb-3">
                        <label for="vezeteknev" class="form-label">Vezetéknév:</label>
                        <input type="text" class="form-control" id="vezeteknev" name="vezeteknev" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary">Register</button>
                </form>
            </div>

            <button onclick="toggleForms()" class="btn btn-secondary" id="toggleButton">Switch to Login</button>
        </div>
    

    <script>
        function toggleForms() {
            var loginForm = document.getElementById("loginForm");
            var registerForm = document.getElementById("registerForm");
            var toggleButton = document.getElementById("toggleButton");

            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
                toggleButton.innerText = "Switch to Register";
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
                toggleButton.innerText = "Switch to Login";
            }
        }

    </script>

</body>
</html>
