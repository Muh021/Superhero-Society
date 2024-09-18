<?php
// Include the database connection file
include 'db_connect.php'; // Make sure this path is correct

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize the form data
    $hero_id = $conn->real_escape_string($_POST['HeroID']);
    $superpower_id = $conn->real_escape_string($_POST['SuperpowerID']);

    // Prepare the SQL statement to insert the data into the hero_superpowers table
    $stmt = $conn->prepare("INSERT INTO hero_superpowers (HeroID, SuperpowerID) VALUES (?, ?)");
    $stmt->bind_param("ii", $hero_id, $superpower_id);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        echo "Superpower assigned to hero successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
    $conn->close();
}
?>
