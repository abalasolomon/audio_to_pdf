
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>Audio To PDF<span>.</span></h3>
            <p>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Useful Links</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="feedback.php">write a  review</a></li>
            </ul>
          </div>

        </div>
      </div>
    </div>

    <div class="container py-4">
      <div class="copyright">
        &copy; Copyright <strong><span>Audio To PDF</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
                
        var user_logged = <?php echo isset($_SESSION['user']) ?  "true" :  "false" ?>;

      $(document).ready(function() {
        function show_logging(logging_val){
           if ( logging_val == true ) {
            $('#save_btn').show();
           }
           else {
            $('#logging').show();
           } 
        }
          $('#uploadForm').on('submit', function(event) {
              event.preventDefault();


                $('#loading').show();
                $('#result').empty();

              var formData = new FormData(this);

              $.ajax({
                  url: 'transcribe.php',
                  type: 'POST',
                  data: formData,
                  contentType: false,
                  processData: false,
                  success: function(response) {
                      $('#result').html('<h2>Transcription Result:</h2><textarea class="form-control" id="transcriptionText" cols="30" rows="8">' + response + '</textarea>');
                       $('#downloadPdf').show();
                       $('#loading').hide();
                       //show_logging(user_logged);
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      console.log('errorThrown' + errorThrown)
                      $('#loading').hide();
                      $('#errorResult').html('<h2 class="text-danger">Error:</h2><p class="text-danger">' + errorThrown + '</p>');
                  }
              });
          });
          $('#downloadPdf').on('click', function() {
              var { jsPDF } = window.jspdf;
              var doc = new jsPDF();

              var transcriptionText = $('#transcriptionText').val(); // Use .val() to get the value of the textarea

              // Split the text into lines for multi-page support
              var lines = doc.splitTextToSize(transcriptionText, 180); // Adjust line width as needed

              var y = 10;
              for (var i = 0; i < lines.length; i++) {
                  if (y > 280) { // Check if we need a new page
                      doc.addPage();
                      y = 10; // Reset y coordinate for the new page
                  }
                  doc.text(10, y, lines[i]);
                  y += 10; // Adjust line height as needed
              }

              doc.save('transcription.pdf');
          });
      });

    </script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
   <script src="assets/js/voice.js" ></script> 
  <script src="assets/js/sweetalert.js"></script>
<?php if (isset($_SESSION['error'])){
  echo "
    <script>
    Swal.fire('$_SESSION[error]')
  </script>
  ";
  unset($_SESSION['error']);
}elseif(isset($_SESSION['success'])){
    echo "
    <script>
    Swal.fire('$_SESSION[success]')
  </script>
  ";
}
  unset($_SESSION['success']);

?>


</body>

</html>