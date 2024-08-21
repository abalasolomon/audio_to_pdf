<?php include 'includes/header.php';
$project = $_GET['project_id']; 
$all_projects = get_projects($project); // Retrieves all services
$count = 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Loop through the uploaded images

    foreach ($_FILES['images']['tmp_name'] as $index => $tmp_name) {
        $file_name = $_FILES['images']['name'][$index];
        $file_tmp = $_FILES['images']['tmp_name'][$index];
        $photo_caption = $_POST['tag'][$index];
        $project_id = $_POST['project_id'];
        // Define the folder where the image will be saved (adjust this path)
        $upload_dir = '../assets/uploads/';

        // Generate a unique file name
        $photo_url = $upload_dir . uniqid() . '_' . $file_name;

        // Move the uploaded file to the specified folder
        move_uploaded_file($file_tmp, $photo_url);
        create_photo( $project_id, $photo_url, $photo_caption);
        // Store the file path in the database (adjust SQL query as needed)
        /*$query = "INSERT INTO Photos (photo_url) VALUES ('$file_path')";
        $result = mysqli_query($connection, $query);*/
    }


}


$photos = get_photos_by_project($_GET['project_id']);
?>         
        <div class="content-">
          <div class="row">

              <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All Services</h4>
                  <p class="card-description">
                    list of all the Projects featured
                  </p>
                  <div class="table-sm pt-3">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                          Project Name
                          </th>
                         <th>
                              Service Name
                          </th>
                          <th>
                            Project Description
                          </th>

                           <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($all_projects as $project): ?>
                        <tr>
                          <td>
                            <?php echo $count; $count ++; ?>
                            
                          </td>
                          <td>
                            <?php echo $project['project_name'] ?>
                          </td>
                          <td>
                            <?php 
                                $service = get_services($project['service_id']);
                                echo $service[0]['service_name'] ?>
                          </td>
                          <td>
                              <?php echo $project['project_description'] ?>
                          </td>

                          <td>
                          </td>
                        </tr>
                          
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Upload Table</h4>


                <button id="addImage" class="btn btn-sm btn-danger mb-3"><i class="mdi mdi-plus-circle"></i></button>
              
                   <form action=" " method="POST" enctype="multipart/form-data">
                      <div id="imageContainer">
                          <!-- Dynamic image input fields will be added here -->
                      </div>
                      <input type="submit" class ="btn btn-sm btn-block btn-primary mt-3" value="Upload">
                      <input type="hidden" name="project_id"  value="<?=$project['project_id']?>" >
                  </form>

    
                </div>
              </div>
            </div>


            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                      
                  <h4 class="card-title">Project images</h4>
                  <div class="row">
                  <?php foreach ($photos as $photo ): ?>
                    <div class="col-md-3">
                    <img src="<?=$photo['photo_url']?>" class=" img img-thumbnail" alt="">
                    <h6><?= $photo['photo_caption'] ?></h6>
                    </div>
                  <?php endforeach ?>
                  </div>
    
                </div>
              </div>
            </div>

          </div>
        </div>

<?php include 'includes/footer.php'; ?>
    <script>
        // Your jQuery code will go here
        
        $(document).ready(function() {
            var maxImages = 6; // Set the maximum number of images allowed
            var imageContainer = $('#imageContainer');

            $('#addImage').click(function() {
                if (imageContainer.children().length < maxImages) {
                    var inputField = $('<input type="file" name="images[]" class="form-control" accept="image/*"> <input type="text" name="tag[]" class="form-control m-2" placeholder = "Enter caption" accept="image/*">');
                    imageContainer.append(inputField);
                } else {
                    alert('Maximum number of images reached.');
                }
            });
        });

    </script>