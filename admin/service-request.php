<?php include 'includes/header.php'; 
$query = "SELECT * FROM service_request JOIN users USING(user_id) ";
$result = mysqli_query($connection, $query);

$count = 1; 
?>
      <div class="main-panel">          
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All Services</h4>
                  <p class="card-description">
                    list of all the request
                  </p>
                  <div class="table-responsive pt-3">
                    <table class="table table-dark">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                          Username 
                          </th>
                          <th>
                          Email
                          </th>
                          <th>
                           Duration (weeks)
                          </th>
                          <th>
                            Budget
                          </th>
                           <th>
                            Start Date
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ( $request = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                          <td>
                            <?php echo $count; $count ++; ?>
                            
                          </td>
                          <td>  
                            <?php echo $request['username'] ?>

                          </td>
                          <td>  
                            <?php echo $request['email'] ?>

                          </td> 
                          <td>
                            <?php echo $request['duration'] ?>
                          </td>
                          <td>
                              <?php echo $request['budget'] ?>
                          </td>
                          <td>
                              <?php echo $request['start_date'] ?>

                          </td>
                        </tr>
                          
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
          

<?php include 'includes/footer.php'; ?>
