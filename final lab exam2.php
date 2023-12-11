<?php

    $conn = mysqli_connect('127.0.0.1', 'root', '', 'labExam');
    $sql = "select * from users";
    $result = mysqli_query($conn, $sql);
    
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Sanitize input
    $username = mysqli_real_escape_string($conn, $username);

    // Retrieve the password for the provided username from the database
    $sql = "SELECT password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
                                           
        if (password_verify($password, $hashed_password)) {
            header("Location: home.html");
            exit();
        } else {
            header("Location: login.html");
            exit();
        }
    } else {
        header("Location: login.html");
        exit();
    }
}

$conn->close();
?>