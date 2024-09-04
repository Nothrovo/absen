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

// Handle POST request for updating status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $id = isset($_POST['id']) ? intval($_POST['id']) : null;
    $status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : null;

    // Check if the input is valid
    if (!is_null($id) && !is_null($status)) {
        // Prepare the SQL statement
        $sql = "UPDATE absen SET status = '$status' WHERE id = $id";

        // Execute the SQL query
        if ($conn->query($sql) === TRUE) {
            echo "Status updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "Invalid input provided.";
    }
} else {
    // Fetch attendance data
    $sql = "SELECT * FROM absen";
    $result = $conn->query($sql);

    // Prepare array to store data
    $absenData = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $absenData[] = $row;
        }
    } else {
        echo "0 results";
    }

    // Encode the data as JSON
    echo json_encode($absenData);
}

$conn->close();
?>