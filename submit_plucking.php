<?php
// DB connection variables
$host = 'localhost';
$username = 'root'; // default for XAMPP
$password = '';     // default is empty
$database = 'tea_factory';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form inputs
$date = $_POST['date'];
$amount = $_POST['amount'];

// Prepare SQL
$sql = "INSERT INTO plucking_data (date, amount) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sd", $date, $amount); // "s" = string, "d" = double

if ($stmt->execute()) {
    echo "<h2>✅ Data inserted successfully!</h2>";
    echo "<a href='tea_plucker_dashboard.html'>← Back to Form</a>";
} else {
    echo "<h2>❌ Error inserting data: " . $stmt->error . "</h2>";
}

// Close connection
$stmt->close();
$conn->close();
?>
