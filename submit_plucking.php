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

echo "<pre>POST data received:\n";
var_dump($_POST);
echo "</pre>";

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
        if ($stmt->affected_rows > 0) {
            echo "<h2>✅ Data inserted successfully! </h2>";
        } else {
            echo "<h2>❌ No rows inserted.</h2>";
        }
    } else {
        echo "<h2>❌ Error executing statement: " . $stmt->error . "</h2>";
    }

    $stmt->close();
} else {
    echo "<h2>⚠️ Missing Form Data.</h2>";
}

$conn->close();
?>
