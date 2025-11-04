<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Complaint System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>System Login</h2>
        
        <form action="login_process.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Login">
        </form>
        
        <?php
            // Show an error message if login failed
            if (isset($_GET['error'])) {
                echo '<p style="color:red; text-align:center;">Invalid username or password.</p>';
            }
        ?>
    </div>
</body>
</html>