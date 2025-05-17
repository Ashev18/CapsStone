<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $surname = $_POST['surname'];
    $middle_name = $_POST['middle_name'];
    $address = $_POST['address'];
    $course_track = $_POST['course_track'];
    $year_level = $_POST['year_level'];
    $lrn = $_POST['lrn'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, email, first_name, surname, middle_name, address, course_track, year_level, lrn)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $username, $hashed_password, $email, $first_name, $surname, $middle_name, $address, $course_track, $year_level, $lrn);

    if ($stmt->execute()) {
        header("Location: register.html?success=1");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
