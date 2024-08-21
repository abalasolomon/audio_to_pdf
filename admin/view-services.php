<?php include 'includes/header.php'; 
$all_services = get_services(); // Retrieves all services
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
                    list of all the service featured
                  </p>
                  <div class="table-responsive pt-3">
                    <table class="table table-dark">
                      <thead>
                        <tr>
                          <th>
                            #
                          </th>
                          <th>
                          Service Name
                          </th>
                          <th>
                            Service Description
                          </th>
                          <th>
                            Created
                          </th>
                           <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($all_services as $service): ?>
                        <tr>
                          <td>
                            <?php echo $count; $count ++; ?>
                            
                          </td>
                          <td>
                            <?php echo $service['service_name'] ?>
                          </td>
                          <td>
                              <?php echo $service['service_description'] ?>
                          </td>
                          <td>
                              <?php echo $service['created_at'] ?>

                          </td>
                          <td>
                            <a href="edit-service.php?service_id=<?=$service['service_id']?>" class="btn btn-primary">
                              Edit
                            </a>
                            <a href="delete-service.php?service_id=<?=$service['service_id']?>" class="btn btn-danger">
                              Delete
                            </a>
                          </td>
                        </tr>
                          
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php include 'includes/footer.php'; ?>
