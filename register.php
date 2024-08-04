<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $picture = $_FILES['picture']['name'];
    $target = "uploads/".basename($picture);
    move_uploaded_file($_FILES['picture']['tmp_name'], $target);

    $sql = "INSERT INTO user (first_name, last_name, email, phone_number, address, picture, password, role) 
            VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$address', '$picture', '$password', 'user')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_picture'] = $picture;
        $_SESSION['role'] = 'user';
        header('Location: home.php');
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"> <!-- Ensure this path is correct -->
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center de-text-success mb-4">Register</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group mb-3">
            <label for="first_name" class="de-text-dark">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group mb-3">
            <label for="last_name" class="de-text-dark">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group mb-3">
            <label for="email" class="de-text-dark">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group mb-3">
            <label for="phone_number" class="de-text-dark">Phone Number:</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
        </div>
        <div class="form-group mb-3">
            <label for="address" class="de-text-dark">Address:</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="form-group mb-3">
            <label for="picture" class="de-text-dark">Picture:</label>
            <input type="file" class="form-control-file" id="picture" name="picture" required>
        </div>
        <div class="form-group mb-4">
            <label for="password" class="de-text-dark">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary-custom btn-custom w-100">Register</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
