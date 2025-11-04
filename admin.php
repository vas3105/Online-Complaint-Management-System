<?php
session_start(); // Connect to the session

// Check if user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    // Not logged in or not an admin, redirect to login
    header("Location: login.php");
    exit;
}

// --- Your existing code starts here ---
include 'db_connect.php';

// --- Handle Status Update ---
// Check if a form was submitted to update a status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $complaint_id = $_POST['id'];
    $new_status = $_POST['status'];
    
    // --- Security Improvement: Use Prepared Statements ---
    $stmt = $conn->prepare("UPDATE complaints SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $complaint_id);
    $stmt->execute();
    $stmt->close();
    // $conn->query($update_sql); // Replaced with prepared statement
}

// --- Fetch All Complaints ---
$sql = "SELECT id, name, roll_no, category, description, status FROM complaints";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
<div class="container"> <div class="header-container">
        [cite_start]<h2>Admin Complaint Dashboard</h2> [cite: 54]
        <a href="logout.php" class="logout-link">Logout</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Roll No</th>
            <th>Category</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["roll_no"] . "</td>";
                echo "<td>" . $row["category"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["status"] . "</td>";
                
                // Form to update status
                echo "<td>
                        <form action='admin.php' method='POST'>
                            <input type='hidden' name='id' value='" . $row["id"] . "'>
                            <select name='status'>
                                <option value='Pending' " . ($row["status"] == 'Pending' ? 'selected' : '') . ">Pending</option>
                                <option value='Resolved' " . ($row["status"] == 'Resolved' ? 'selected' : '') . ">Resolved</option>
                            </select>
                            <input type='submit' name='update_status' value='Update'>
                        </form>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No complaints found</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div> </body>
</html>