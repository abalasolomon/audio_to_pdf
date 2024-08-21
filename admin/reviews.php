<?php   include 'includes/header.php';
//$all_services = get_services(); // Retrieves all services
 


$query = "SELECT * FROM Comments JOIN users  USING(user_id) JOIN Projects  USING(project_id)  ";
$result = mysqli_query($connection, $query);

if ($result) {
    $comments = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $comments[] = $row;
    }
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
                <textarea name="comment" id="" cols="" rows="5" class="form-control">
                  
                </textarea>

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
