<?php
session_start();

// Optional: Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <style>
    /* Your existing CSS styles */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: #f2f5f7;
    }

    header {
      background-color: #0d47a1;
      color: white;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header h1 {
      font-size: 22px;
    }

    .welcome {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .logout-btn {
      background-color: #e53935;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    main {
      padding: 30px 40px;
    }

    .card {
      background-color: white;
      border-radius: 10px;
      padding: 20px 25px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
      margin-bottom: 25px;
      position: relative;
    }

    .profile-card {
      margin-bottom: 30px;
    }

    .profile-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .card h2 {
      margin-bottom: 10px;
      text-transform: capitalize;
    }

    .info-group {
      display: flex;
      flex-wrap: wrap;
      gap: 25px;
      margin-bottom: 30px;
    }

    .info-block {
      flex: 1;
      min-width: 280px;
      background-color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }

    .info-block h3 {
      margin-bottom: 10px;
      font-size: 16px;
    }

    .info-block p {
      margin: 5px 0;
    }

    .info-label {
      font-weight: bold;
    }

    .profile-box {
      position: static;
      width: 120px;
      height: 120px;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .profile-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border: 2px solid #ccc;
      border-radius: 10px;
    }

    .profile-box input[type="file"] {
      display: none;
    }

    .upload-label,
    .change-picture-btn {
      background: #3498db;
      color: white;
      padding: 5px 10px;
      border-radius: 4px;
      cursor: pointer;
      margin-top: 10px;
      text-align: center;
      width: 100%;
    }

    .upload-label:hover {
      background: #2980b9;
    }

    .change-picture-btn {
      background: #2ecc71;
      display: none;
    }

    .change-picture-btn:hover {
      background: #27ae60;
    }

    .verify-buttons {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }

    .verify-buttons button {
      background: #e74c3c;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
    }

    .verify-buttons button:hover {
      background: #c0392b;
    }
  </style>
</head>
<body>

  <header>
    <h1>User Authentication System</h1>
    <div class="welcome">
      <span>Welcome, <span id="username"></span></span>
      <form action="logout.php" method="post" style="display:inline;">
        <button type="submit" class="logout-btn">Logout</button>
      </form>
    </div>
  </header>

  <main>
    <div class="card profile-card">
      <div class="profile-header">
        <div>
          <h2>Welcome, <span id="welcome-username"></span>!</h2>
          <p>You have successfully logged into your account. Below you can find your profile information.</p>
        </div>
        <div class="profile-box">
          <img id="profile-image" src="https://via.placeholder.com/100" alt="Profile Picture">
          <input type="file" id="file-input" accept="image/*">
          <label for="file-input" class="upload-label" id="upload-label">Upload Photo</label>
          <button id="change-picture-btn" class="change-picture-btn">Change Picture</button>
        </div>
      </div>
    </div>

    <div class="info-group">
      <div class="info-block">
        <h3>Personal Information</h3>
        <p><span class="info-label">Full Name:</span> <span id="full-name"></span></p>
        <p><span class="info-label">Username:</span> <span id="display-username"></span></p>
        <p><span class="info-label">Email:</span> <span id="email"></span></p>
        <p><span class="info-label">Address:</span> <span id="address"></span></p>
      </div>

      <div class="info-block">
        <h3>Academic Information</h3>
        <p><span class="info-label">Course/Track:</span> <span id="course-track"></span></p>
        <p><span class="info-label">Year Level:</span> <span id="year-level"></span></p>
      </div>
    </div>

    <div class="card">
      <h3>Recent Activity</h3>
      <p>You logged in at <?php echo date('h:i:s A'); ?> on <?php echo date('n/j/Y'); ?>.</p>
      <p>No recent activities to display.</p>

      <div class="verify-buttons">
        <button onclick="verifySHS()">Verify Your Account (SHS)</button>
        <button onclick="verifyCollege()">Verify Your Account (College)</button>
      </div>
    </div>
  </main>

  <script>
    function verifySHS() {
      window.location.href = 'draft-cumulative-record.html';
    }

    function verifyCollege() {
      window.location.href = 'college-cumulative-record.html';
    }

    const fileInput = document.getElementById('file-input');
    const profileImage = document.getElementById('profile-image');
    const uploadLabel = document.getElementById('upload-label');
    const changePictureBtn = document.getElementById('change-picture-btn');

    fileInput.addEventListener('change', function(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          profileImage.src = e.target.result;
          uploadLabel.style.display = 'none';
          changePictureBtn.style.display = 'block';
        };
        reader.readAsDataURL(file);
      }
    });

    changePictureBtn.addEventListener('click', function() {
      fileInput.click();
    });

    // Fetch user data
    fetch('UserPageBackEnd.php')
      .then(response => {
        if (!response.ok) {
          throw new Error("Not authorized");
        }
        return response.json();
      })
      .then(data => {
        const user = data[0];
        document.getElementById('username').textContent = user.username;
        document.getElementById('welcome-username').textContent = user.username;
        document.getElementById('display-username').textContent = user.username;
        document.getElementById('full-name').textContent = `${user.first_name} ${user.middle_name ? user.middle_name + ' ' : ''}${user.surname}`;
        document.getElementById('email').textContent = user.email;
        document.getElementById('address').textContent = user.address;
        document.getElementById('course-track').textContent = user.course_track;
        document.getElementById('year-level').textContent = user.year_level;
      })
      .catch(error => {
        console.error("Error:", error);
        alert("Failed to fetch user data. Please log in again.");
        window.location.href = 'login.html';
      });
  </script>

</body>
</html>
