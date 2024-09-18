<?php
// Include the database connection file
include 'db_connect.php'; // Make sure this path is correct

// Check if the form was submitted for adding a mission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['MissionID'])) {
    // Retrieve and sanitize the form data for adding a mission
    $mission_id = $conn->real_escape_string($_POST['MissionID']);
    $name = $conn->real_escape_string($_POST['Name']);
    $hero_id = $conn->real_escape_string($_POST['HeroID']);
    $people_saved = $conn->real_escape_string($_POST['People_Saved']);
    $people_lost = $conn->real_escape_string($_POST['People_Lost']);
    $villain_id = $conn->real_escape_string($_POST['VillainID']);
    $priority_level = $conn->real_escape_string($_POST['Priority_Level']);

    // Prepare the SQL statement to insert the data into the Missions table
    $stmt = $conn->prepare("INSERT INTO Missions (MissionID, Name, HeroID, People_Saved, People_Lost, VillainID, Priority_Level) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isiisis", $mission_id, $name, $hero_id, $people_saved, $people_lost, $villain_id, $priority_level);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        echo "New mission added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

// Check if the form was submitted for deleting a mission
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['DeleteMissionID'])) {
    // Retrieve and sanitize the form data for deleting a mission
    $delete_mission_id = $conn->real_escape_string($_POST['DeleteMissionID']);

    // Prepare the SQL statement to delete the data from the Missions table
    $stmt = $conn->prepare("DELETE FROM Missions WHERE MissionID = ?");
    $stmt->bind_param("i", $delete_mission_id);

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Mission deleted successfully!";
        } else {
            echo "No mission found with ID " . $delete_mission_id;
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Always close the connection
$conn->close();
?>