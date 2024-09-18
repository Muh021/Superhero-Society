<?php
// Include the database connection file
include 'db_connect.php'; // Make sure this path is correct

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['AgentID']) && !isset($_POST['UpdateAgentID'])) {
        // Adding a new agent with multiple query capability
        $agent_id = $_POST['AgentID']; // Not escaped; be cautious!
        $name = $_POST['Name']; // Not escaped; be cautious!
        $dob = $_POST['DOB']; // Not escaped; be cautious!
        $salary = $_POST['Salary']; // Not escaped; be cautious!
        $experience = $_POST['Experience']; // Not escaped; be cautious!

        // Construct the SQL statement with multiple queries
        $sql = "INSERT INTO Agent (AgentID, Name, DOB, Salary, Experience) VALUES ('$agent_id', '$name', '$dob', '$salary', '$experience');";
        // Add more queries here if needed, separated by semicolons
        // Example: $sql .= "UPDATE Agent SET Salary = 75000 WHERE AgentID = '$agent_id';";

        // Execute the multi queries
        if ($conn->multi_query($sql)) {
            echo "New agent added successfully!";
            // Process all results
            do {
                if ($result = $conn->store_result()) {
                    while ($row = $result->fetch_row()) {
                        // Output results or process them
                    }
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
        } else {
            echo "Error: " . $conn->error;
        }
    }
    elseif (isset($_POST['UpdateAgentID'])) {
        // Updating an existing agent with multiple query capability
        $update_agent_id = $_POST['UpdateAgentID']; // Not escaped; be cautious!
        $update_name = $_POST['UpdateName'] ?? ''; // Not escaped; be cautious!
        $update_dob = $_POST['UpdateDOB'] ?? ''; // Not escaped; be cautious!
        $update_salary = $_POST['UpdateSalary'] ?? ''; // Not escaped; be cautious!
        $update_experience = $_POST['UpdateExperience'] ?? ''; // Not escaped; be cautious!

        // Construct the SQL update statement with possibility for multiple queries
        $sql = "UPDATE Agent SET Name='$update_name', DOB='$update_dob', Salary='$update_salary', Experience='$update_experience' WHERE AgentID='$update_agent_id';";
        // Additional queries can be added here

        // Execute the multi queries
        if ($conn->multi_query($sql)) {
            echo "Agent updated successfully!";
            // Process all results
            do {
                if ($result = $conn->store_result()) {
                    while ($row = $result->fetch_row()) {
                        // Output results or process them
                    }
                    $result->free();
                }
            } while ($conn->more_results() && $conn->next_result());
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

// Always close the connection
$conn->close();
?>
