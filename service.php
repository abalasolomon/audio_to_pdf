<?php   include 'includes/header.php';
//$all_services = get_services(); // Retrieves all services


// Define the service ID for which you want to fetch projects and images
$serviceId = $_GET['service']; // Replace with the desired service ID

// SQL query to fetch projects and their images for the specified service ID
$query = "SELECT p.project_id, p.project_name, p.project_description, i.photo_url
          FROM Projects AS p
          LEFT JOIN photos AS i ON p.project_id = i.project_id
          WHERE p.service_id = $serviceId";

$result = mysqli_query($connection, $query);

if ($result) {
    // Create an array to store projects and their images
    $projectsWithImages = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $projectId = $row['project_id'];
        $projectName = $row['project_name'];
        $projectDescription = $row['project_description'];
               $imageUrl = $row['photo_url'];

        // Check if the project is already in the array
        if (!isset($projectsWithImages[$projectId])) {
            $projectsWithImages[$projectId] = array(
                'project_name' => $projectName,
                'project_description' => $projectDescription,
                'images' => array(),
            );
        }

        // Add the image URL to the project's images array
        if ($imageUrl !== null) {
            $projectsWithImages[$projectId]['images'][] = $imageUrl;
        }
    }

} 

// Close the database connection
mysqli_close($connection);
?>



<section id="services" class="services">
  <div class="container" data-aos="fade-up">
    <div class="section-title">
      <h2>Services</h2>
      <h3>Check our <span><?=$projectName?></span></h3>
      <p>We do have a bunch of projects you can view</p>
    </div>
    <div class="row">
      <?php foreach ($projectsWithImages as $projectId => $projectData): ?>
        <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
          <div class="icon-box">
            <?php if (!empty($projectData['images'])): ?>
              <div class="images">
                <?php foreach ($projectData['images'] as $imageUrl){
                $file_path = str_replace('../', '', $imageUrl); ?>
                  <img src="<?= $file_path ?>" alt="Project Image" class="medium-image">
                  <?php     break;  ?>
                <?php } ?>
              </div>
            <?php endif; ?>
            <h4><a href="project-details.php?project_id=<?= $projectId?>"><?= $projectData['project_name'] ?></a></h4>
            <p><?= $projectData['project_description'] ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>




<?php   include 'includes/footer.php'; ?>
