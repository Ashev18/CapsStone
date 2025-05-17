<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Northlink Technological College</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            width: 400px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .container label {
            display: block;
            margin-top: 10px;
        }
        .container input {
            width: 94%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .remember-container {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .remember-container input {
            width: auto;
            margin-right: 5px;
        }
        .forgot-password {
            float: right;
            font-size: 15px;
            color: #0073e6;
            text-decoration: none;
        }
        .container button {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #0073e6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .container button:hover {
            background-color: #005bb5;
        }
        .new-account {
            background-color: #ccc;
            color: black;
        }
        .new-account:hover {
            background-color: #bbb;
        }

    </style>
</head>
<body>
    <div class="logo">
        <img class="img-fluid" src="https://northlink.edu.ph/lms/pluginfile.php/1/core_admin/logo/0x200/1724498623/ntc%20logo.PNG" title="myNTC" alt="myNTC" id="yui_3_17_2_1_1739764588388_77">
    </div>
    <div class="container">
        <h2 style="color: #005bb5">GUIDANCE OFFICE</h2>
        <form action="login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <div class="remember-container">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember username</label>
                <a href="#" class="forgot-password">Forgotten your username or password?</a>
            </div>
            <button type="submit">Log in</button>
        </form>
        <button class="new-account" onclick="window.location.href='register.html'">Create new Account</button>
    </div>
</body>
</html>
