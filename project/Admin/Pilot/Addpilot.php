<?php
// Include the database connection
include('../connection.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Collect the form data
    $pi_f_name = $_POST['pi_f_name'];
    $pi_m_name = $_POST['pi_m_name'];
    $pi_l_name = $_POST['pi_l_name'];
    $licence_no = $_POST['licence_no'];
    $flight_hr = $_POST['flight_hr'];
    $salary = $_POST['salary'];
    $dob = $_POST['dob'];
    
    // Check if the 'is_captain' checkbox is ticked
    $is_captain = isset($_POST['is_captain']) ? 1 : 0;

    // Prepare the SQL query to insert the data into the "pilot" table
    $query = "INSERT INTO pilot (pi_f_name, pi_m_name, pi_l_name, licence_no, flight_hr, salary, dob)
              VALUES ('$pi_f_name', '$pi_m_name', '$pi_l_name', '$licence_no', '$flight_hr', '$salary', '$dob')";

    // Execute the query and check for success
    if (mysqli_query($conn, $query)) {
        // Get the last inserted pilot ID
        $pilot_id = mysqli_insert_id($conn);

        // If the pilot is a captain, insert into the "captain" table
        if ($is_captain) {
            $captain_query = "INSERT INTO captain (pilot_id) VALUES ('$pilot_id')";
            if (mysqli_query($conn, $captain_query)) {
                header("location: ../homepage.php");
                echo "<script>alert('Pilot added successfully, and assigned as Captain!');</script>";
                
            } else {
                echo "<script>alert('Error assigning pilot as Captain: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            header("location: ../homepage.php");
            echo "<script>alert('Pilot added successfully!');</script>";
           
        }
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
