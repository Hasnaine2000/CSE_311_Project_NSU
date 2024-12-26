<?php
include '../connection.php'; // Include your connection script

if (isset($_POST['submit'])) {
    
    $airline_name = $_POST['airline_name'];
    $contact_info = $_POST['contact_info'];

    // SQL query to insert data into the airline table
    $query = "INSERT INTO airline (airline_name, contact_info) VALUES (?, ?)";
    
    // Prepare and execute the query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ss", $airline_name, $contact_info);
        
        if ($stmt->execute()) {
            header("location: ../homepage.php");
            
        } else {
            echo "<script>alert('Error: Could not add airline');</script>";
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
