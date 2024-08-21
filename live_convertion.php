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
        
        <h1>Voice To Text Converter</h1>
        <textarea name="convert_text" id="convert_text" class="form-control" cols="30" rows="10"></textarea>
        <button class="btn btn-success m-1" id="click_to_convert">Voice to text</button>
        <button class="btn btn-info m-1" style="display:none;" id="download_pdf">Download PDF</button>

      </div>

      <div id="text-part" class="text-part">
        
      </div>
    </div>
  </section><!-- End Hero -->
<?php   include 'includes/footer.php'; ?>