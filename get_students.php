<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "sad";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT lrn, first_name, middle_name, surname, address, course_track FROM users"; // adjust if table is named differently
$result = $conn->query($sql);

$students = [];
while($row = $result->fetch_assoc()) {
    $students[] = $row;
}

header('Content-Type: application/json');
echo json_encode($students);

$conn->close();
?>
