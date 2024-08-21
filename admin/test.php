<?php
session_start();

$connection = mysqli_connect('localhost', 'root', '', 'portfolio');

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Loop through the uploaded images
    foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
        $file_name = $_FILES['images']['name'][$index];
        $file_tmp = $_FILES['images']['tmp_name'][$index];
        
        // Define the folder where the image will be saved (adjust this path)
        $upload_dir = 'uploads/';

        // Generate a unique file name
        $file_path = $upload_dir . uniqid() . '_' . $file_name;

        // Move the uploaded file to the specified folder
        move_uploaded_file($file_tmp, $file_path);

        // Store the file path in the database (adjust SQL query as needed)
        $query = "INSERT INTO Photos (photo_url) VALUES ('$file_path')";
        $result = mysqli_query($connection, $query);
    }

    $_SESSION['success'] = "Images uploaded successfully.";
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Your HTML content here -->

    <button id="addImage">Add Image</button>
    <div id="imageContainer">
       <form action=" " method="POST" enctype="multipart/form-data">
    <button id="addImage">Add Image</button>
    <div id="imageContainer">
        <!-- Dynamic image input fields will be added here -->
    </div>
    <input type="submit" value="Upload">
</form>

    </div>

    <script>
        // Your jQuery code will go here
        <!-- Inside the <script> tag -->
        $(document).ready(function() {
            var maxImages = 5; // Set the maximum number of images allowed
            var imageContainer = $('#imageContainer');

            $('#addImage').click(function() {
                if (imageContainer.children().length < maxImages) {
                    var inputField = $('<input type="file" name="images[]" accept="image/*"><br>');
                    imageContainer.append(inputField);
                } else {
                    alert('Maximum number of images reached.');
                }
            });
        });

    </script>
</body>
</html>
