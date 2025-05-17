<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "sad";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user = $_POST['username'] ?? '';
$pass = $_POST['password'] ?? '';

// Check for empty input
if (empty($user) || empty($pass)) {
    die("Please enter username and password.");
}

// Query the user
$sql = "SELECT id, password FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // For now, skip password_verify() if passwords are stored as plain text
    if ($pass === $row['password']) {
        $_SESSION['user_id'] = $row['id'];
        header("Location: UserPage.php");
        exit();
    } else {
        echo "Incorrect password.";
    }
} else {
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>
