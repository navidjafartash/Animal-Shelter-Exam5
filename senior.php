<?php
include 'connection.php';
include 'inc/navbar.php';


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is an admin and redirect to admin.php
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header('Location: admin.php');
    exit();
}

// Fetch senior animals from the database
$sql = "SELECT * FROM animal WHERE age > 8";
$result = $conn->query($sql);


$animalCards = '';
while ($row = $result->fetch_assoc()) {
    $statusTag = ($row['status'] == 'Adopted') ? '<div class="adopted-tag">Adopted</div>' : '';
    $adoptButton = ($row['status'] == 'Available') 
        ? '<form method="post" action="adopt.php" class="d-inline-block">
               <input type="hidden" name="pet_id" value="' . htmlspecialchars($row['id']) . '">
               <button type="submit" class="btn btn-success-custom btn-custom" style="background-color: #ff6f61; border-color: #ff6f61;">Take me home</button>
           </form>'
        : '';

    $animalCards .= '
        <div class="col">
            <div class="card animal-card">
                ' . $statusTag . '
                <img src="uploads/' . htmlspecialchars($row['photo']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                    <hr class="de-divider">
                    <p class="card-text"><strong>Age:</strong> ' . htmlspecialchars($row['age']) . '</p>
                    <p class="card-text">' . htmlspecialchars($row['description']) . '</p>
                    <a href="details.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-info-custom btn-custom" style="background-color: #ff9a9e; border-color: #ff9a9e;">Show More</a>
                    ' . $adoptButton . '
                </div>
            </div>
        </div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Senior Pets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"> <!-- Ensure this path is correct -->
</head>
<body>

<div class="container mt-5">
    <h1 class="admin-panel-heading">Senior Pets</h1>
    <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
        <?= $animalCards; ?>
    </div>
</div>

<?php include 'inc/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
