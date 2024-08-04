<?php
include 'connection.php';
include 'inc/navbar.php';

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is an admin and redirect to admin.php
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    header('Location: admin.php');
    exit();
}

//  filter variables
$statusFilter = isset($_POST['status']) ? $_POST['status'] : '';
$ageFilter = isset($_POST['age']) ? $_POST['age'] : '';


$sql = "SELECT * FROM animal WHERE 1=1";

if (!empty($statusFilter)) {
    $sql .= " AND status = '" . $conn->real_escape_string($statusFilter) . "'";
}

if (!empty($ageFilter)) {
    switch ($ageFilter) {
        case 'young':
            $sql .= " AND age < 2";
            break;
        case 'adult':
            $sql .= " AND age BETWEEN 2 AND 7";
            break;
        case 'senior':
            $sql .= " AND age >= 8";
            break;
    }
}

$result = $conn->query($sql);


$animalCards = '';
while ($row = $result->fetch_assoc()) {
    $statusTag = ($row['status'] == 'Adopted') ? '<div class="adopted-tag">Adopted</div>' : '';
    $adoptButton = ($row['status'] == 'Available') 
        ? '<form method="post" action="adopt.php" class="d-inline-block">
               <input type="hidden" name="pet_id" value="' . htmlspecialchars($row['id']) . '">
               <button type="submit" class="btn btn-success-custom btn-custom">Take me home</button>
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
                    <a href="details.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-info-custom btn-custom">Show More</a>
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
    <title>All Animals</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>

<div class="container mt-5">
    <h1 class="admin-panel-heading">All Animals</h1>
    
    
    <form method="post" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">Select Status</option>
                    <option value="Available" <?= $statusFilter == 'Available' ? 'selected' : '' ?>>Available</option>
                    <option value="Adopted" <?= $statusFilter == 'Adopted' ? 'selected' : '' ?>>Adopted</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="age" class="form-select">
                    <option value="">Select Age</option>
                    <option value="young" <?= $ageFilter == 'young' ? 'selected' : '' ?>>Young (&lt; 2 years)</option>
                    <option value="adult" <?= $ageFilter == 'adult' ? 'selected' : '' ?>>Adult (2-7 years)</option>
                    <option value="senior" <?= $ageFilter == 'senior' ? 'selected' : '' ?>>Senior (&gt;= 8 years)</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success-custom btn-custom">Apply Filters</button>
            </div>
        </div>
    </form>

    <div class="row row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 g-4">
        <?= $animalCards; ?>
    </div>
</div>

<?php include 'inc/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
