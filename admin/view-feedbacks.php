<?php   include 'includes/header.php';
if (!isset($_SESSION['user'])){
  $_SESSION['error'] = "Please signin to continue";
    redirect("../signin.php");  
}

$query = "SELECT * FROM feedback join Users using(user_id) ";
$result = mysqli_query($connection, $query);


?>
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Users Table</h4>
                  <p class="card-description">
                    All feedbacks from registered users 
                  </p>
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>
                            Email
                          </th>
                          <th>
                            First name
                          </th>
                          <th>
                            Feedback
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if ( mysqli_num_rows($result) > 0): ?>
                          <?php   while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                          <td class="py-1"> <?=$row['email']?> </td>

                          <td>
                            <div >
                              <?=$row['first_name']?>
                          </td>
                          <td>
                              <?=$row['content']?>
                          </td>
                        </tr>
                      <?php } else: ?>  
                        <h1> No feedback </h1>
                        <?php endif ?>


                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
          
<?php include 'includes/footer.php'; ?>