<?php
require_once "connection.php";
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$query = "SELECT animal.* FROM animal JOIN pet_adoption ON animal.id = pet_adoption.pet_id WHERE pet_adoption.user_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$adopted_pets = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile - Pet Adoption</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2>Profile</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h5>
                <p class="card-text"><?php echo $user['email']; ?></p>
                <img src="uploads/<?php echo $user['picture']; ?>" alt="<?php echo $user['first_name']; ?>" class="img-fluid" style="max-width: 200px;">
            </div>
        </div>
        <h3>Adopted Pets</h3>
        <?php while ($pet = $adopted_pets->fetch_assoc()): ?>
            <div class="card mb-4">
                <img src="uploads/<?php echo $pet['photo']; ?>" class="card-img-top" alt="<?php echo $pet['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $pet['name']; ?></h5>
                    <p class="card-text"><?php echo $pet['description']; ?></p>
                    <p class="card-text"><small class="text-muted"><?php echo $pet['status']; ?></small></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
