<?php
include 'connection.php';
include 'inc/navbar.php';


if (!isset($_SESSION['user_email']) || $_SESSION['role'] != 'admin') {
    header('Location: home.php');
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM animal WHERE id=$id";
    $conn->query($sql);
}

// Fetch all animals
$sql = "SELECT * FROM animal";
$animalsResult = $conn->query($sql);

// Fetch adopted pets
$adoptedPetsSql = "SELECT a.*, pa.adoption_date, u.first_name, u.last_name
                   FROM animal a
                   JOIN pet_adoption pa ON a.id = pa.pet_id
                   JOIN user u ON pa.user_id = u.id
                   WHERE a.status = 'Adopted'";
$adoptedPetsResult = $conn->query($adoptedPetsSql);

// Fetch senior pets
$seniorPetsSql = "SELECT * FROM animal WHERE age >= 8";
$seniorPetsResult = $conn->query($seniorPetsSql);

// Generate animal cards for all animals
$animalCards = '';
while ($row = $animalsResult->fetch_assoc()) {
    $animalCards .= '
        <div class="col">
            <div class="card animal-card">
                <img src="uploads/' . htmlspecialchars($row['photo']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                    <hr class="de-divider">
                    <p class="card-text">' . htmlspecialchars(substr($row['description'], 0, 100) . '...') . '</p>
                    <p class="card-text"><strong>Age:</strong> ' . htmlspecialchars($row['age']) . ' years</p>
                    <p class="card-text"><strong>Status:</strong> ' . htmlspecialchars($row['status']) . '</p>
                    <a href="edit_animal.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-warning-custom btn-custom">Edit</a>
                    <form method="post" action="admin.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">
                        <button type="submit" name="delete" class="btn btn-danger-custom btn-custom" onclick="return confirm(\'Are you sure you want to delete this animal?\');">Delete</button>
                    </form>
                </div>
            </div>
        </div>';
}

// Generate animal cards for adopted pets
$adoptedPetCards = '';
while ($row = $adoptedPetsResult->fetch_assoc()) {
    $adoptedPetCards .= '
        <div class="col">
            <div class="card animal-card">
                <div class="adopted-tag">Adopted</div>
                <img src="uploads/' . htmlspecialchars($row['photo']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                    <hr class="de-divider">
                    <p class="card-text">' . htmlspecialchars(substr($row['description'], 0, 100) . '...') . '</p>
                    <p class="card-text"><strong>Age:</strong> ' . htmlspecialchars($row['age']) . ' years</p>
                    <p class="card-text"><strong>Status:</strong> ' . htmlspecialchars($row['status']) . '</p>
                    <a href="edit_animal.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-warning-custom btn-custom">Edit</a>
                    <form method="post" action="admin.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">
                        <button type="submit" name="delete" class="btn btn-danger-custom btn-custom" onclick="return confirm(\'Are you sure you want to delete this animal?\');">Delete</button>
                    </form>
                </div>
            </div>
        </div>';
}

// Generate animal cards for senior pets
$seniorPetCards = '';
while ($row = $seniorPetsResult->fetch_assoc()) {
    $seniorPetCards .= '
        <div class="col">
            <div class="card animal-card">
                <img src="uploads/' . htmlspecialchars($row['photo']) . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                    <hr class="de-divider">
                    <p class="card-text">' . htmlspecialchars($row['description']) . '</p>
                    <p class="card-text"><strong>Age:</strong> ' . htmlspecialchars($row['age']) . ' years</p>
                    <p class="card-text"><strong>Status:</strong> ' . htmlspecialchars($row['status']) . '</p>
                    <a href="edit_animal.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-warning-custom btn-custom">Edit</a>
                    <form method="post" action="admin.php" style="display:inline-block;">
                        <input type="hidden" name="id" value="' . htmlspecialchars($row['id']) . '">
                        <button type="submit" name="delete" class="btn btn-danger-custom btn-custom" onclick="return confirm(\'Are you sure you want to delete this animal?\');">Delete</button>
                    </form>
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
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="admin-panel-heading">Admin Panel</h1>
    <a href="create_animal.php" class="btn btn-primary-custom mb-3 btn-custom">Add New Animal</a>
    
    
    <div class="mb-4">
        <a href="admin.php" class="btn btn-secondary<?= !isset($_GET['view']) || $_GET['view'] == 'all' ? ' active' : ''; ?>">All Animals</a>
        <a href="admin.php?view=adopted" class="btn btn-secondary<?= isset($_GET['view']) && $_GET['view'] == 'adopted' ? ' active' : ''; ?>">Adopted Pets</a>
        <a href="admin.php?view=senior" class="btn btn-secondary<?= isset($_GET['view']) && $_GET['view'] == 'senior' ? ' active' : ''; ?>">Senior Pets</a>
    </div>
    
    <?php if (!isset($_GET['view']) || $_GET['view'] == 'all') { ?>
        <h2>All Animals</h2>
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
            <?= $animalCards; ?>
        </div>
    <?php } elseif ($_GET['view'] == 'adopted') { ?>
        <h2>Adopted Pets</h2>
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
            <?= $adoptedPetCards; ?>
        </div>
    <?php } elseif ($_GET['view'] == 'senior') { ?>
        <h2>Senior Pets</h2>
        <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
            <?= $seniorPetCards; ?>
        </div>
    <?php } ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<?php include 'inc/footer.php'; ?>
</body>
</html>
