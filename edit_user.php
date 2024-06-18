<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $photo = $_FILES['photo'];

    $conn = new mysqli('localhost', 'root', '', 'hw1_user_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($photo['name']) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($photo["name"]);
        move_uploaded_file($photo["tmp_name"], $target_file);

        $sql = "UPDATE users SET username = '$username', email = '$email', photo = '$target_file' WHERE id = $id";
    } else {
        $sql = "UPDATE users SET username = '$username', email = '$email' WHERE id = $id";
    }

    if ($conn->query($sql) === TRUE) {
        echo "User updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

