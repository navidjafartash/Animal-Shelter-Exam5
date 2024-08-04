<?php
require_once "connection.php";
session_start();

if ($_SESSION['role'] != 'admin') {
    header("Location: home.php");
    exit();
}

$animal_id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM animal WHERE id = ?");
$stmt->bind_param("i", $animal_id);

if ($stmt->execute()) {
    header("Location: admin.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
