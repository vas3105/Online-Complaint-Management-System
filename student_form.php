<?php
session_start(); // Connect to the session
// Check if user is logged in and is a student
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'student') {
    // Not logged in or not a student, redirect to login
    header("Location: login.php");
    exit;
}

include 'db_connect.php';
$student_roll_no = $_SESSION['roll_no'];
$stmt = $conn->prepare("SELECT category, description, status FROM complaints WHERE roll_no = ? ORDER BY id DESC");
$stmt->bind_param("s", $student_roll_no);
$stmt->execute();
$complaint_result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    
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
        .status-pending {
            font-weight: bold;
            color: #ffc107;
        }
        .status-resolved {
            font-weight: bold;
            color: #28a745;
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
            <option value="Hostel">Hostel</option>
            <option value="Classroom">Classroom</option>
            <option value="Admin">Administration</option>
            <option value="Other">Other</option>
        </select>
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4" required></textarea> 
        <input type="submit" value="Submit Complaint">
    </form>

    <hr style="margin-top: 30px;">
    <h2>My Past Complaints</h2>
    
    <table>
        <tr>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
        </tr>
        
        <?php
        if ($complaint_result->num_rows > 0) {
            while($row = $complaint_result->fetch_assoc()) {
                
                $status_class = '';
                if ($row["status"] == 'Pending') {
                    $status_class = 'status-pending';
                } else if ($row["status"] == 'Resolved') {
                    $status_class = 'status-resolved';
                }

                echo "<tr>";
                echo "<td>" . $row["category"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td class='" . $status_class . "'>" . $row["status"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>You have not submitted any complaints yet.</td></tr>";
        }
        
        // Close the database connections
        $stmt->close();
        $conn->close();
        ?>
    </table>


    <script>
        function validateForm() {
            var name = document.getElementById('name').value;
            var roll_no = document.getElementById('roll_no').value;
            if (name == "" || roll_no == "") {
                alert("Name and Roll No must be filled out");
                return false;
            }
            return true;
        }
    </script>

</div>

</body>
</html>
