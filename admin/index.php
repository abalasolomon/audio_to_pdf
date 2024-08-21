<?php   include 'includes/header.php';
if (!isset($_SESSION['user'])){
  $_SESSION['error'] = "Please signin to continue";
    redirect("../signin.php");  
} 
?>
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
              <div class="home-tab">
                <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                  <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active ps-0" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#audiences" role="tab" aria-selected="false">Audiences</a>
                    </li>
                  </ul>
                  <div>
                    <div class="btn-wrapper">

                    </div>
                  </div>
                </div>
                <div class="tab-content tab-content-basic">
                  <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"> 
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="statistics-details d-flex align-items-center justify-content-between">
                          <div>
                            <p class="statistics-title">Audio Converted</p>
                            <h3 class="rate-percentage">30%</h3>
                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>30</span></p>
                          </div>
                          <div>
                            <p class="statistics-title">Live Convertion</p>
                            <h3 class="rate-percentage">27</h3>
                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>27</span></p>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title">Users</p>
                            <h3 class="rate-percentage">68</h3>
                            <p class="text-danger d-flex"><i class="mdi mdi-menu-down"></i><span>68</span></p>
                          </div>
                          <div class="d-none d-md-block">
                            <p class="statistics-title">Avg. Time on Site</p>
                            <h3 class="rate-percentage">2m:35s</h3>
                            <p class="text-success d-flex"><i class="mdi mdi-menu-down"></i><span>+0.8%</span></p>
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