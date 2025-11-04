<?php
// submit_complaint.php
include 'db_connect.php'; // Get the database connection

// Get data from the HTML form
$name = $_POST['name'];
$roll_no = $_POST['roll_no'];
$category = $_POST['category'];
$description = $_POST['description'];

// Prepare the SQL INSERT query
$sql = "INSERT INTO complaints (name, roll_no, category, description) 
        VALUES ('$name', '$roll_no', '$category', '$description')";

if ($conn->query($sql) === TRUE) {
    header("Location: student_form.php?status=success");
    // You can redirect back to the form or a 'thank you' page
    // header("Location: index.html?status=success");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>