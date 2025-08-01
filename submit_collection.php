<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tea_factory';

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

if (isset($_POST['plucker_id'], $_POST['date'], $_POST['amount'])) {
    $plucker_id = trim($_POST['plucker_id']);
    $date = trim($_POST['date']);
    $amount = floatval($_POST['amount']);

    if ($plucker_id === '' || $date === '' || $amount <= 0) {
        die("<h2>⚠️ Please fill all fields correctly.</h2>");
    }

    $sql = "INSERT INTO plucking_data (plucker_id, date, amount) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("❌ SQL Prepare Error: " . $conn->error);
    }

    $stmt->bind_param("ssd", $plucker_id, $date, $amount);

    if ($stmt->execute()) {
        echo "<h2 style='text-align:center; color:green;'>✅ Data inserted successfully!</h2>";
        echo "<div style='text-align:center; margin-top:20px;'>
                <a href='tea_collection_form.html' style='text-decoration:none; font-size:18px;'>← Back to Form</a>
              </div>";
    } else {
        echo "<h2>❌ Error executing statement: " . $stmt->error . "</h2>";
    }

    $stmt->close();
} else {
    echo "<h2>⚠️ Missing form data.</h2>";
}

$conn->close();
?>
