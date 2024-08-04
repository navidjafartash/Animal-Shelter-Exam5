<?php
session_start();

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['user_email']) || $_SESSION['role'] != 'admin') {
    header('Location: home.php');
    exit();
}

include 'connection.php';
include 'inc/navbar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM animal WHERE id=$id";
    $result = $conn->query($sql);
    $animal = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $size = $_POST['size'];
    $age = $_POST['age'];
    $vaccinated = $_POST['vaccinated'];
    $breed = $_POST['breed'];
    $status = $_POST['status'];

    $sql = "UPDATE animal SET name='$name', description='$description', location='$location', size='$size', age='$age', vaccinated='$vaccinated', breed='$breed', status='$status' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        
        if ($status == 'Adopted') {
            $user_id = $_SESSION['user_id']; 
            $adoption_date = date('Y-m-d H:i:s');

           
            $adopt_check_sql = "SELECT * FROM pet_adoption WHERE pet_id='$id'";
            $adopt_check_result = $conn->query($adopt_check_sql);

            if ($adopt_check_result->num_rows == 0) {
                $insert_sql = "INSERT INTO pet_adoption (user_id, pet_id, adoption_date) VALUES ('$user_id', '$id', '$adoption_date')";
                if ($conn->query($insert_sql) !== TRUE) {
                    echo "Error: " . $insert_sql . "<br>" . $conn->error;
                }
            }
        } elseif ($status == 'Available') {
            
            $delete_sql = "DELETE FROM pet_adoption WHERE pet_id='$id'";
            if ($conn->query($delete_sql) !== TRUE) {
                echo "Error: " . $delete_sql . "<br>" . $conn->error;
            }
        }

        header('Location: admin.php');
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Animal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container mt-5">
    <h1 class="admin-panel-heading">Edit Animal</h1>
    <form method="post" action="edit_animal.php">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($animal['id']); ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($animal['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required><?php echo htmlspecialchars($animal['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($animal['location']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="size" class="form-label">Size</label>
            <input type="text" class="form-control" id="size" name="size" value="<?php echo htmlspecialchars($animal['size']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="age" class="form-label">Age</label>
            <input type="text" class="form-control" id="age" name="age" value="<?php echo htmlspecialchars($animal['age']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="vaccinated" class="form-label">Vaccinated</label>
            <select class="form-control" id="vaccinated" name="vaccinated" required>
                <option value="1" <?php echo $animal['vaccinated'] ? 'selected' : ''; ?>>Yes</option>
                <option value="0" <?php echo !$animal['vaccinated'] ? 'selected' : ''; ?>>No</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="breed" class="form-label">Breed</label>
            <input type="text" class="form-control" id="breed" name="breed" value="<?php echo htmlspecialchars($animal['breed']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Available" <?php echo $animal['status'] == 'Available' ? 'selected' : ''; ?>>Available</option>
                <option value="Adopted" <?php echo $animal['status'] == 'Adopted' ? 'selected' : ''; ?>>Adopted</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary-custom mb-3 btn-custom">Update Animal</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php include 'inc/footer.php'; ?>
</body>
</html>
