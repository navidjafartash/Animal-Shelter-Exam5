<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['pet_id'])) {
        $user_id = intval($_SESSION['user_id']);
        $pet_id = intval($_POST['pet_id']);
        $adoption_date = date('Y-m-d H:i:s');

        
        $insert_sql = "INSERT INTO pet_adoption (user_id, pet_id, adoption_date) VALUES ('$user_id', '$pet_id', '$adoption_date')";
        if ($conn->query($insert_sql) === TRUE) {
            
            $update_sql = "UPDATE animal SET status='Adopted' WHERE id='$pet_id'";
            if ($conn->query($update_sql) === TRUE) {
                header('Location: home.php'); 
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    } else {
        echo "Pet ID not provided.";
    }
}


if (isset($_GET['id'])) {
    $pet_id = intval($_GET['id']);
    $sql = "SELECT * FROM animal WHERE id='$pet_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $pet = $result->fetch_assoc();
    } else {
        echo "No pet found with that ID.";
        exit();
    }
} else {
    echo "No pet ID provided.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h1>Adopt Pet</h1>
    <div class="card">
        <img src="uploads/<?php echo htmlspecialchars($pet['photo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($pet['name']); ?>">
        <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($pet['name']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($pet['description']); ?></p>
            <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($pet['location']); ?></p>
            <p class="card-text"><strong>Age:</strong> <?php echo htmlspecialchars($pet['age']); ?> years</p>
            <p class="card-text"><strong>Breed:</strong> <?php echo htmlspecialchars($pet['breed']); ?></p>
            <form method="post" action="adopt.php">
                <input type="hidden" name="pet_id" value="<?php echo htmlspecialchars($pet['id']); ?>">
                <button type="submit" class="btn btn-primary">Adopt</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
