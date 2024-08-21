<?php   include 'includes/header.php';
//$all_services = get_services(); // Retrieves all services


$connection = mysqli_connect('localhost', 'root', '', 'portfolio');

// Fetch projects based on the provided service ID
$query = "SELECT * FROM job_requests WHERE user_id = '$_SESSION[user_id]' ";
$result = mysqli_query($connection, $query);
$count = 1; 
if (isset($_POST['submit'])) {

    $location = $_POST["location"];
    $startDate = $_POST["startDate"];
    $status = 'pending';
    $jobRequestId = $_POST["hiddenValue"];

    // Call the createServiceRequest function to insert the data
    $newServiceRequestId = createServiceRequest($location,$_SESSION['user_id'], $startDate, $status, $jobRequestId);

    if ($newServiceRequestId !== false) {
        $_SESSION['success'] = "Service request with ID $newServiceRequestId has been created. You will receive a call from us";

    } else {
        $_SESSION['error'] = "Failed to create the service request.";
     
    }
  }
 ?>

     <section id="services" class="services">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>My Requests</h2>
          <h3>Check your <span> Requests</span></h3>
          <p>List of analysis  you requested </p>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive pt-3">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                          Project ID
                          </th>
                          <th>
                            Request Description
                          </th>
                          <th>
                            Analysis
                          </th>
                           <th>
                            Analysis With Market
                          </th>
                        </tr>
                      </thead>
                      <tbody> 
                <?php



                 while ($request = mysqli_fetch_assoc( $result )){
                  ?>
                  <tr>  
                    <td> <?=$count; $count++?></td>
                    <td> <?=$request['id']?></td>
                    <td><?=$request['description']?></td>
                    <td><?=is_null($request['analysis']) ? 'Wait for respond' : $request['analysis'] ?></td>
                    <td><?=empty($request['market_analysis']) ? 'Wait for respond' : $request['market_analysis'] ?></td>
                    <td>
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#projectModal" data-hidden-value="<?=$request['id']?>">
                       Request service
                      </button>
                    </td>
                  </tr> 
                <?php } ?>
                        </tbody>
                    </table>
                  </div>
            </div>

        </div>

      </div>
    </section>


<!-- Bootstrap Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel">Project Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Hidden Input Field for Storing the Value -->

                <!-- Project Information Form -->
                <form id="projectForm" method="post">
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                <input type="hidden" id="hiddenValue" name="hiddenValue" value="1">

                    <div class="form-group">
                        <label for="startDate">Expected Start Date:</label>
                        <input type="date" class="form-control" id="startDate" name="startDate" required>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- JavaScript to Set Hidden Field Value -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    // Set the hidden input field value when a button is clicked
    $('[data-toggle="modal"]').click(function () {
        var hiddenValue = $(this).data('hidden-value');
         $('#hiddenValue').value = hiddenValue;
        
    });

    // Handle form submission
    $("#projectForm").submit(function (event) {
        // Validation
        var startDate = new Date($('#startDate').val());
        var currentDate = new Date();


        if (startDate <= currentDate) {
            alert("Please select a future date for the project start.");
            event.preventDefault(); // Prevent the form from submitting
            return;
        }



        // If the form passes validation, the default form submission will occur
        // You can add your actual submission logic here if needed

        // Close the modal
        $("#projectModal").modal('hide');
    });
});
</script>
<?php   include 'includes/footer.php'; ?>
   