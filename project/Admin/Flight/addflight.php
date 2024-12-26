<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    include "../connection.php";

    // Retrieve form data
    $flight_no = $_POST['flight_no'];
    $from_ = $_POST['from_'];
    $to_ = $_POST['to_'];
    $dep_time = $_POST['dep_time'];
    $arr_time = $_POST['arr_time'];
    $plane_id = $_POST['plane_id'];
    $airline_id = $_POST['airline_id'];

    // SQL query to insert data
    $sql = "INSERT INTO flight (flight_no, from_, to_, dep_time, arr_time, plane_id, airline_id)
            VALUES ('$flight_no', '$from_', '$to_', '$dep_time', '$arr_time', '$plane_id', '$airline_id')";

    if ($conn->query($sql) === TRUE) {
        
        header("location: ../homepage.php");
       
     
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the connection
    $conn->close();
}
?>
