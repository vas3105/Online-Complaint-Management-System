<?php
// login_process.php (Original Working Version)
session_start();
include 'db_connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    // Verify the hashed password
    if (password_verify($password, $user['password'])) {
        // Password is correct!
        // Store user data in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['roll_no'] = $user['roll_no'];
        
        // Redirect based on role
        if ($user['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: student_form.php");
        }
    } else {
        // Invalid password
        header("Location: login.php?error=1");
    }
} else {
    // Invalid username
    header("Location: login.php?error=1");
}

$stmt->close();
$conn->close();
?>