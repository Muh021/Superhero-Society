<?php
// Include the database connection file
include 'db_connect.php'; // Make sure this path is correct

// Check if the form to add was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    // Common form data for adding
    $age = $conn->real_escape_string($_POST['age']);
    $name = $conn->real_escape_string($_POST['name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $archnemesis = $conn->real_escape_string($_POST['archnemesis']);

    if ($_POST['type'] == 'hero') {
        // Hero-specific form data
        $heroId = $conn->real_escape_string($_POST['heroId']);
        $peopleSaved = $conn->real_escape_string($_POST['peopleSaved']);
        $agentId = $conn->real_escape_string($_POST['agentId']);
        $seniority = $conn->real_escape_string($_POST['seniority']);

        // Prepare the SQL statement for the Hero table
        $stmt = $conn->prepare("INSERT INTO Heroes (HeroID, Name, Age, DOB, Archnemesis, People_Saved, AgentID, Seniority) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isissiis", $heroId, $name, $age, $dob, $archnemesis, $peopleSaved, $agentId, $seniority);

    } else if ($_POST['type'] == 'villain') {
        // Villain-specific form data
        $villainId = $conn->real_escape_string($_POST['villainId']);
        $peopleKilled = $conn->real_escape_string($_POST['peopleKilled']);

        // Prepare the SQL statement for the Villain table
        $stmt = $conn->prepare("INSERT INTO Villains (VillainID, Name, Age, DOB, Archnemesis, People_Killed) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isissi", $villainId, $name, $age, $dob, $archnemesis, $peopleKilled);
    }

    // Execute the statement and check if it was successful
    if ($stmt->execute()) {
        echo ucfirst($_POST['type']) . " added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();

// Check if the form to get was submitted
} else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    // Common form data for retrieval
    $id = $conn->real_escape_string($_POST['id']);
    $type = $_POST['getType'];

    if ($type == 'hero') {
        // Prepare the SQL statement to retrieve a Hero
        $stmt = $conn->prepare("SELECT * FROM Heroes WHERE HeroID = ?");
    } else if ($type == 'villain') {
        // Prepare the SQL statement to retrieve a Villain
        $stmt = $conn->prepare("SELECT * FROM Villains WHERE VillainID = ?");
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the data and display it
        $data = $result->fetch_assoc();
        echo ucfirst($type) . " Details:<br>";
        foreach ($data as $key => $value) {
            echo htmlspecialchars($key) . ": " . htmlspecialchars($value) . "<br>";
        }
    } else {
        echo ucfirst($type) . " not found with ID " . $id;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>