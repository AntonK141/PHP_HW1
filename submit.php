<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $photo = $_FILES['photo'];

    // Directory to upload photos
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($photo["name"]);

    if (move_uploaded_file($photo["tmp_name"], $target_file)) {
        $conn = new mysqli('localhost', 'root', '', 'hw1_user_db');

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO users (username, email, photo) VALUES ('$username', '$email', '$target_file')";
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?message=New user created successfully");
            exit();
        } else {
            $message = "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        $message = "Sorry, there was an error uploading your file.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Submission Result</title>
    <link rel="stylesheet" href="/HW1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Submission Result</h2>
    <div class="alert alert-info" role="alert">
        <?php echo $message; ?>
    </div>
    <a href="create.php" class="btn btn-primary">Back to Create User</a>
</div>
<script src="/HW1/js/bootstrap.bundle.min.js"></script>
</body>
</html>




