<?php
include 'connection.php';
include 'inc/navbar.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $size = $_POST['size'];
    $age = $_POST['age'];
    $vaccinated = isset($_POST['vaccinated']) ? 1 : 0;
    $breed = $_POST['breed'];
    $status = $_POST['status'];

    $photo = $_FILES['photo']['name'];
    $target = "uploads/".basename($photo);
    move_uploaded_file($_FILES['photo']['tmp_name'], $target);

    $sql = "INSERT INTO animal (name, photo, location, description, size, age, vaccinated, breed, status) 
            VALUES ('$name', '$photo', '$location', '$description', '$size', '$age', '$vaccinated', '$breed', '$status')";
    
    if ($conn->query($sql) === TRUE) {
        header('Location: admin.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<div class="container mt-5">
    <h2 class="admin-panel-heading">Add New Animal</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Name:</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="form-group">
            <label>Photo:</label>
            <input type="file" class="form-control-file" name="photo" required>
        </div>
        <div class="form-group">
            <label>Location:</label>
            <input type="text" class="form-control" name="location" required>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label>Size:</label>
            <select class="form-control" name="size" required>
                <option value="Small">Small</option>
                <option value="Medium">Medium</option>
                <option value="Large">Large</option>
            </select>
        </div>
        <div class="form-group">
            <label>Age:</label>
            <input type="number" class="form-control" name="age" required>
        </div>
        <div class="form-group">
            <label>Vaccinated:</label>
            <input type="checkbox" name="vaccinated">
        </div>
        <div class="form-group">
            <label>Breed:</label>
            <input type="text" class="form-control" name="breed" required>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select class="form-control" name="status">
                <option value="Available">Available</option>
                <option value="Adopted">Adopted</option>
            </select>
        </div>
        <button class="btn btn-primary-custom mb-3 btn-custom">Add the Pet 🐶🐱</button>
    </form>
</div>

<?php include 'inc/footer.php'; ?>
