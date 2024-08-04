<?php
session_start();
include 'connection.php';

// Check if user is logged in and has admin role
if (!isset($_SESSION['user_email']) || $_SESSION['role'] != 'admin') {
    header('Location: home.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $id = intval($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']);
    $size = htmlspecialchars($_POST['size']);
    $age = intval($_POST['age']);
    $vaccinated = isset($_POST['vaccinated']) ? 1 : 0;
    $breed = htmlspecialchars($_POST['breed']);
    $status = htmlspecialchars($_POST['status']);

    // Handle file upload
    $photo = $_FILES['photo']['name'];
    if ($photo) {
        $target = "uploads/" . basename($photo);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
            $sql = "UPDATE animal SET name=?, photo=?, location=?, description=?, size=?, age=?, vaccinated=?, breed=?, status=? WHERE id=?";
        } else {
            echo "Failed to upload file.";
            exit();
        }
    } else {
        $sql = "UPDATE animal SET name=?, location=?, description=?, size=?, age=?, vaccinated=?, breed=?, status=? WHERE id=?";
    }

    
    if ($stmt = $conn->prepare($sql)) {
        if ($photo) {
            $stmt->bind_param("sssssiissi", $name, $photo, $location, $description, $size, $age, $vaccinated, $breed, $status, $id);
        } else {
            $stmt->bind_param("sssssiiss", $name, $location, $description, $size, $age, $vaccinated, $breed, $status, $id);
        }
        
        if ($stmt->execute()) {
            header('Location: admin.php');
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Failed to prepare SQL statement.";
    }
    
    $conn->close();
}
?>
