<?php
include 'includes/header.php';

// Fetch materials from the database
$query = "SELECT * FROM Materials";
$result = mysqli_query($connection, $query);

if ($result) {
    $materials = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $materials[] = $row;
    }
}
?>

<!-- Portfolio Details Section -->
<section id="portfolio-details" class="portfolio-details">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="portfolio-info">
                    <h3>Materials</h3>
                    <?php if (isset($materials) && count($materials) > 0): ?>
                        <ul>
                            <?php foreach ($materials as $material): ?>
                                <li><?= $material['material_name'] ?> - Price: <?= $material['price'] ?></li>
                            <?php endforeach ?>
                        </ul>
                    <?php else: ?>
                        <p>No materials found.</p>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Portfolio Details Section -->

<?php include 'includes/footer.php'; ?>
