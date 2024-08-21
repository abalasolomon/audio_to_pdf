<?php   include 'includes/header.php';
//$all_services = get_services(); // Retrieves all services
$projects = get_projects($_GET['project_id']); // Retrieves all services
$photos = get_photos_by_project($_GET['project_id']);
//$file_path = str_replace('../', '', $images[0]['photo_url']);
    if (isset($_POST['submit'])) {
          if ( !isset($_SESSION['user'])) {
            $_SESSION['error'] = "please login to submit comments";
          }else{
              if (empty($_POST['comment'])) {
                  $_SESSION['error'] = "please login to submit comments";
              }else{
                create_comment($_GET['project_id'], $_SESSION['user_id'], trim($_POST['comment']));
                $_SESSION['success'] = "comment submitted";
              }

          }
      }
      if (isset($_POST['request'])) {
          $query = "SELECT * FROM job_requests WHERE user_id = '$_SESSION[user_id]' AND project_id = '$_POST[project_id]'";
          $result = mysqli_query($connection, $query);         // code...
       
          if (mysqli_num_rows($result) > 0) {
              $_SESSION['error'] = "You have a request for analysis on this project already";
          }else{
              $query = "INSERT INTO job_requests( 
                user_id,
                project_id,  
                description ) VALUES( '$_SESSION[user_id]', '$_POST[project_id]', '$_POST[description]')";
              $result = mysqli_query($connection, $query);         // code...
       
              $_SESSION['Success'] = "Your  request for analysis  has been submitted";
              redirect('project-details.php?'. $_GET['project_id']);

          }
       } 

$query = "SELECT * FROM Comments JOIN users  USING(user_id)  WHERE project_id = '$_GET[project_id]' ";
$result = mysqli_query($connection, $query);


if ($result) {
    $comments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }
  }

  if (isset($_POST['request'])) {
                   
    }           
 
 ?>
    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-8">
            <div class="portfolio-details-slider swiper">
              <div class="swiper-wrapper align-items-center">
              	<?php foreach ($photos as $photo){ 
              		$file_path = str_replace('../', '', $photo['photo_url']);
              		?>
              		
                <div class="swiper-slide">
                  <img src="<?=$file_path?>" alt="">
                </div>
              	<?php } ?>



              </div>
              <div class="swiper-pagination"></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Project information</h3>
              <ul>
                <li><strong>Project Id</strong>: <?= $projects[0]['project_id']?></li>
                <li><strong>Project Name</strong>: <?= $projects[0]['project_name']?></li>
                <li><strong>Project date</strong>: 01 March, 2020</li>
                <li><strong>Project Description</strong>: <?= $projects[0]['project_description']?></li>
              </ul>

              <form action="" method="post">
                <input type="hidden" name="project_id"  class="btn">
                <p class="text-info">please enter detailed description including size in sq</p>
                <label for="" class="form-label"> Description</label> 
                <textarea name="description" id="" cols="30" rows="10" class="form-control">
                  
                </textarea>
                
                  <button type="submit" name="request" class="btn btn-info btn-rounded">Request similar design</button>
              </form>
            </div>
            <div class="portfolio-description">
              <h2>This is the project detail</h2>
              <p>
                <?= $projects[0]['project_description']?>
              </p>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="portfolio-info">
              <h3>Write a comment</h3>
              <form action="  " method="post">
                <textarea name="comment" id="" cols="" rows="5" class="form-control" required>
                  
                </textarea>
                  <input type="hidden" name="project_id" <?=$_GET['project_id']?>>
                <button type="submit" name="submit" class="btn btn-success mt-2"> Submit comment  </button>
              </form>
            </div>
          </div>

          <div class="col-lg-8">
            <div class="portfolio-info">
              <h3>comments</h3>
              <?php if (isset($comments)): ?>
                <?php foreach ($comments as $comment): ?>
                <h6>  <?=$comment['first_name'] ?> <?=$comment['first_name'] ?></h6>
                <p> <?=$comment['comment_text'] ?></p>
                  
                <?php endforeach ?>
              <?php endif ?>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Portfolio Details Section -->

<?php   include 'includes/footer.php'; ?>
