<?php 
$severname = 'localhost';
$username = 'root';
$password = '';
$dbname = 'project';


 $conn = new mysqli($severname, $username, $password, $dbname);

 if ($conn->connect_error) {
    die('Connection Failed'. $conn->connect_error);
 }else{
    
 }