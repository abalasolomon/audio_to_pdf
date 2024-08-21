<?php   include 'includes/header.php';
if (!isset($_SESSION['user'])){
  $_SESSION['error'] = "Please signin to continue";
    redirect("signin.php");  
}
?>
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">

      <div class="live-audio-control">
			
        

        <div class="row">
        	<div id="loading" class="alert alert-success" style="display: none;" >Processing... Please wait.</div>
        	<div class="col-md-6">
        		<h1 class="alert ">UPLOAD AUDIO FILE</h1>
        		<div id="errorResult"> </div>
			    <form id="uploadForm" >
			        <input type="file" class="form-control"  name="audioFile" id="audioFile" accept="audio/*" required>
			        <button type="submit" class="btn btn-success mt-3" >Submit</button>
			    </form>

        	</div>

		  	<div class="col-md-6">
	  			<h1 class="alert " >TEXT RESULT </h1>
	  			<div id="result"></div>
	  			<button id="downloadPdf" class="btn btn-info mt-2" style="display:none;">Download PDF</button>
	  			<button id="save_btn" class="btn btn-info mt-2" style="display:none;">Save Document</button>
	  			<a href="signin.php" id="logging" class="btn btn-info mt-2" style="display:none;"></a>
        	</div>
        </div>	        

      </div>

      <div id="text-part" class="text-part">
        
      </div>
    </div>
  </section><!-- End Hero -->
<?php   include 'includes/footer.php'; ?>


