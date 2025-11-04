<?php
session_start(); // Connect to the session
// Check if user is logged in and is a student
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    // Not logged in or not a student, redirect to login
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Complaint</title>
    
    <link rel="stylesheet" href="style.css">
    
    <style>
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logout-link {
            text-decoration: none;
            background-color: #dc3545;
            color: white;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        .logout-link:hover {
            background-color: #c82333;
        }
    </style>
    
</head>
<body>

<div class="container">

    <div class="header-container">
        <h2>Online Complaint Management System</h2>
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
        <?php
    if (isset($_GET['status']) && $_GET['status'] == 'success') {
        echo '<p style="color:green; text-align:center; background-color:#e6ffed; padding:10px; border-radius:4px;">
                New complaint submitted successfully!
            </p>';
    }
    ?>
    <form action="submit_complaint.php" method="POST" onsubmit="return validateForm()">
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" readonly>

        <label for="roll_no">Roll No:</label>
        <input type="text" id="roll_no" name="roll_no" value="<?php echo $_SESSION['roll_no']; ?>" readonly>
        
        <label for="category">Category:</label>
        <select id="category" name="category" required> 
            <option value="">Select Category</option>
            [cite_start]<option value="Hostel">Hostel</option> [cite: 43]
            [cite_start]<option value="Classroom">Classroom</option> [cite: 43]
            [cite_start]<option value="Admin">Administration</option> [cite: 43]
            <option value="Other">Other</option>
        </select>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea> 
        
        <input type="submit" value="Submit Complaint">
    </form>

    <script>
        function validateForm() {
            [cite_start]// Basic validation [cite: 53]
            var name = document.getElementById('name').value;
            var roll_no = document.getElementById('roll_no').value;
            if (name == "" || roll_no == "") {
                alert("Name and Roll No must be filled out");
                return false;
            }
            return true;
        }
    </script>

</div> </body>
</html>