<?php
// Include the database connection file
include 'db_connect.php'; // Make sure this path is correct

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize the form data
    $villain_id = $conn->real_escape_string($_POST['VillainID']);
    $superpower_id = $conn->real_escape_string($_POST['SuperpowerID']);

    // Prepare the SQL statement to insert the data into the villain_superpowers table
    $stmt = $conn->prepare("INSERT INTO villain_superpowers (VillainID, SuperpowerID) VALUES (?, ?)");
    $stmt->bind_param("ii", $villain_id, $superpower_id);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        echo "Superpower assigned to villain successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>
