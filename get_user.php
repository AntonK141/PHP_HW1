<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = new mysqli('localhost', 'root', '', 'hw1_user_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode([]);
    }

    $conn->close();
}
?>

