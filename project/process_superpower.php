<?php
// Include the database connection file
include 'db_connect.php'; // Make sure this path is correct

// Check if the form was submitted for adding a new superpower
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize the form data
    $superpower_id = $conn->real_escape_string($_POST['superpowerId']);
    $name = $conn->real_escape_string($_POST['superpowerName']);
    $description = $conn->real_escape_string($_POST['superpowerDescription']);

    // Prepare the SQL statement to insert the data into the Superpowers table
    $stmt = $conn->prepare("INSERT INTO Superpowers (SuperpowerID, Name, Description) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $superpower_id, $name, $description);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        echo "New superpower added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['superpowerId'])) { // Check for GET request to retrieve a superpower
    // Retrieve superpower ID directly from the GET variable (not recommended in production)
    $superpower_id = $_GET['superpowerId'];

    // Direct SQL query
    $sql = "SELECT * FROM Superpowers WHERE SuperpowerID = $superpower_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "ID: " . $row['SuperpowerID'] . " - Name: " . $row['Name'] . " - Description: " . $row['Description'] . "<br>";
        }
    } else {
        echo "No superpower found with ID: $superpower_id";
    }
}

// Close the connection
$conn->close();
?>
