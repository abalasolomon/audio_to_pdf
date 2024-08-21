<?php   include 'includes/header.php';
if (!isset($_SESSION['user'])){
  $_SESSION['error'] = "Please signin to continue";
    redirect("signin.php");  
}

if (isset($_POST['submit'])) {
	$post = cleanPost($_POST);
	    $query = "INSERT INTO feedback ( user_id,content) 
              VALUES ( '$_SESSION[user_id]', '$post[feedback]')";
    $result = mysqli_query($connection, $query);
    $_SESSION['success'] = "Thanks for the feedback";
}
?>
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">

      <div class="live-audio-control">
        <div class="row">
        	<div class="col-md-8">
        		<h1 class="alert ">Write a Review</h1>
        		<div id="errorResult"> </div>
			    <form method="post" >
			        <textarea  class="form-control"  name="feedback" id="feedback" required> </textarea>
			        <button type="submit" name="submit" class="btn btn-success mt-3" >Submit</button>
			    </form>

        	</div>

      </div>

      <div id="text-part" class="text-part">
        
      </div>
    </div>
  </section><!-- End Hero -->
<?php   include 'includes/footer.php'; ?>


