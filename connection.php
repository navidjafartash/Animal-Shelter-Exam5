<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "be22_exam5_animal_adoption_navidjafartash";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

