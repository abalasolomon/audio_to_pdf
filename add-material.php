<?php
include 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $material_name = mysqli_real_escape_string($connection, $_POST['name']);

    // Check if the material name contains digits
    if (preg_match('/\d/', $material_name)) {
        $_SESSION['error'] = 'Material name should not contain digits.';
    } else {
        // Check if the material name already exists in the database
        $query = "SELECT * FROM Materials WHERE material_name = '$material_name'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error'] = 'Material with this name already exists.';
        } else {
            // Insert the material into the database
            $query = "INSERT INTO Materials (material_name) VALUES ('$material_name')";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $_SESSION['success'] = 'Material added successfully.';
            } else {
                $_SESSION['error'] = 'Error adding material.';
            }
        }
    }
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Add New Material</h4>
                        <form class="form-inline" method="post">
                            <label class="sr-only" for="inlineFormInputName2">Name</label>
                            <input type="text" name="name" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" placeholder="Material Name">

                            <button type="submit" class="btn btn-primary mb-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
