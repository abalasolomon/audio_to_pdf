<?php
include 'includes/header.php';

// Fetch materials from the database
$query = "SELECT * FROM Materials";
$result = mysqli_query($connection, $query);

$count = 1;
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Material List</h4>
                        <p class="card-description">
                            List of all materials
                        </p>
                        <div class="table-responsive pt-3">
                            <table class="table table-dark">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Material Name</th>
                                        <th>Price</th>
                                        <th>Action</th> <!-- Add Edit column -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($material = mysqli_fetch_assoc($result)) { ?>
                                        <tr>
                                            <td><?php echo $count;
                                                $count++; ?></td>
                                            <td><?php echo $material['material_name'] ?></td>
                                            <td><?php echo $material['price'] ?></td>
                                            <td>
                                                <a href="edit-material.php?material_id=<?php echo $material['material_id']; ?>" class="btn btn-warning">Edit</a>
                                                 <a href="delete-material.php?material_id=<?php echo $material['material_id']; ?>">Delete</a>
                                            </td> <!-- Add Edit button with a link to edit-material.php -->
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
