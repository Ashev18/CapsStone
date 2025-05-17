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

// Make sure the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); // Unauthorized
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT username, email, first_name, middle_name, surname, address, course_track, year_level 
        FROM users 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$user_data = [];
if ($result->num_rows === 1) {
    $user_data[] = $result->fetch_assoc();
}

header('Content-Type: application/json');
echo json_encode($user_data);

$stmt->close();
$conn->close();
?>
