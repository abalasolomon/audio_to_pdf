<?php include 'includes/header.php'; 
$all_projects = get_projects(); // Retrieves all services
$count = 1;
?>
      <div class="main-panel">          
        <div class="content-">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">All Services</h4>
                  <p class="card-description">
                    list of all the Projects featured
                  </p>
                  <div class="table-responsive pt-3">
                    <table class="table table-dark">
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
                            <a href="edit-project.php?project_id=<?=$project['project_id']?>" class="btn btn-primary">
                              <i class="mdi mdi mdi-border-color">  </i>  
                            </a>


                            <a href="view-project.php?project_id=<?=$project['project_id']?>" class="btn btn-info">
                              <i class="mdi mdi-clipboard-text">  </i>
                            </a>

                            <a href="delete-project.php?project_id=<?=$project['service_id']?>" class="btn btn-danger">
                              <i  class="mdi mdi-delete"> </i>
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
