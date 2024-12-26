<?php

include("connection.php");


if (isset($_POST["submit"])) {
    echo "dhukse?";
    $fn = $_POST["fn"];
    $mn = $_POST["mn"];
    $ln = $_POST["ln"];
    $email = $_POST["email"];
    $pn = $_POST["pn"];
    $dob = $_POST["dob"];
    $password = $_POST["password"];


    $sql = "INSERT INTO `user`(`us_f_name`,`us_m_name`, `us_l_name`, `email`, `DOB`, `phone_no`, `password`) VALUES ('$fn','$mn','$ln','$email','$dob','$pn','$password')";
    
    if($conn->query($sql)== TRUE){
        echo"data inserted";
        header("location: login.html");
    }else{
        echo"Not inserted";
        header("location: signup.html");
    }
}


