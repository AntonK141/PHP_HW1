<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $conn = new mysqli('localhost', 'root', '', 'hw1_user_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT photo FROM users WHERE id = $id";
    $result = $conn->query($sql);
    $photo = $result->fetch_assoc()['photo'];

    $sql = "DELETE FROM users WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        if (file_exists($photo)) {
            unlink($photo);
        }
        echo "User deleted successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

