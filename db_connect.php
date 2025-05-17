<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "sad"; // Your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";
// Optionally, you can echo a success message or log it
// echo "Connected successfully!";

// Close the connection (optional, as PHP will close it when the script ends)
// $conn->close();
?>
