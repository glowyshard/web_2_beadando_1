<?php require_once('config.inc.php');

class OpinionModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getOpinions() {
        $opinions = array();

        $result = $this->conn->query("SELECT * FROM opinions");

        while ($row = $result->fetch_assoc()) {
            $opinions[] = $row;
        }

        return $opinions;
    }

    public function addOpinion($username, $opinion_text) {
        $stmt = $this->conn->prepare("INSERT INTO opinions (usernames, opinion_text) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $opinion_text);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}


class OpinionController {
    private $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function showOpinions() {
        $opinions = $this->model->getOpinions();

        foreach ($opinions as $opinion) {
            echo "<div>";
            echo "<p>Username: " . $opinion['usernames'] . "</p>";
            echo "<p>Hír/Vélemény: " . $opinion['opinion_text'] . "</p>";
            echo "<p>Created At: " . $opinion['created_at'] . "</p>";
            echo "</div>";
        }
    }

    public function submitOpinion($username, $opinion_text) {
        $success = $this->model->addOpinion($username, $opinion_text);

        if ($success) {
            
        } else {
            echo "Failed to submit opinion.";
        }
    }
}


$databaseConnection = new mysqli('localhost', 'root', '', 'users_db');

if ($databaseConnection->connect_error) {
    die("Connection failed: " . $databaseConnection->connect_error);
}

require_once('config.inc.php');

$opinionModel = new OpinionModel($databaseConnection);
$opinionController = new OpinionController($opinionModel);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitOpinion'])) {
        $username = $_SESSION['login_name']; 
        $opinion_text = $_POST['opinion_text'];
        $opinionController->submitOpinion($username, $opinion_text);
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"> 
    <title>Véleményezés</title>
</head>

<body>
    <?php require_once("header.php"); ?>
    <div class="container d-flex align-items-center flex-column content-container">
        <h1>Hírlevél</h1>
   
    <?php $opinionController->showOpinions(); ?>

    <form class="text-center" method="post" action="">
        <div class="mb-3">
            <textarea class="form-control" name="opinion_text" rows="4" placeholder="Write your opinion..."></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submitOpinion">Submit Opinion</button>
    </form>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>