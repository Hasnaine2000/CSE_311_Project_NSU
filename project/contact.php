<?php

include("connection.php");


if (isset($_POST["submit"])) {
   
    $email = $_POST["email"];
    
    $text = $_POST["text"];


    $sql = "INSERT INTO `queries`(`email`,`query_text`) VALUES ('$email','$text')";
    
    if($conn->query($sql)== TRUE){
        echo"data inserted";
       header("location: index.html");
        
    }else{
        echo"Not inserted";
       header("location: contact.html");
      
    }
}


