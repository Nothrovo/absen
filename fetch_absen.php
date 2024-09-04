<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kelas_c";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch attendance data
$sql = "SELECT * FROM absen";
$result = $conn->query($sql);

// Prepare array to store data
$absenData = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $absenData[] = $row;
    }
} else {
    echo "0 results";
}

// Encode the data as JSON
echo json_encode($absenData);

$conn->close();
?>