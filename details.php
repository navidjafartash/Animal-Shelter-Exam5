<?php
include 'connection.php';
include 'inc/navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animal WHERE id=$id";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container mt-5 de-details">
    <div class="row">
        <div class="col-md-6">
            
            <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" class="img-fluid de-img mb-4 rounded">
        </div>
        <div class="col-md-6">
            
            <h2 class="de-text-success"><?php echo htmlspecialchars($row['name']); ?></h2>
            <h4 class="de-description"><?php echo htmlspecialchars($row['description']); ?></h4>
            <p class="de-text-dark"><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
            <hr class="de-divider">
            <p class="de-text-dark"><strong>Size:</strong> <?php echo htmlspecialchars($row['size']); ?></p>
            <hr class="de-divider">
            <p class="de-text-dark"><strong>Age:</strong> <?php echo htmlspecialchars($row['age']); ?></p>
            <hr class="de-divider">
            <p class="de-text-dark"><strong>Vaccinated:</strong> <?php echo $row['vaccinated'] ? 'Yes' : 'No'; ?></p>
            <hr class="de-divider">
            <p class="de-text-dark"><strong>Breed:</strong> <?php echo htmlspecialchars($row['breed']); ?></p>
            <hr class="de-divider">
            <p class="de-text-dark"><strong>Status:</strong> <?php echo htmlspecialchars($row['status']); ?></p>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
