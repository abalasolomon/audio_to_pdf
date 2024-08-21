<?php   
	include 'includes/header.php';
	if (isset($_POST['submit'])) {
		$errors = [];
	 	if (!validate_input($_POST['email'], 'email')) {
	 		$errors = "please enter email";
	 	}
	 	if (!validate_input($_POST['email'], 'email')) {
	 		$errors = "please enter email";
	 	}

	 	if (empty($errors)) {
	 		$user = login_user($_POST['email'], $_POST['password']);
	 		if ($user) {

                $_SESSION['user'] = $user;
	 			if ($_SESSION['role'] == "user") {
                    redirect("index.php");
                    exit();
                }else{
                    redirect("admin");
                    exit();
                }
	 		}
	 		else{
	 			$errors = "Invalid user or password";
	 		}
	 	}
	 } 
?>

<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2> Sign In</h2>
      
    </div>

  </div>
</section><!-- End Breadcrumbs -->

<section class="inner-page">
  <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <!-- <div class="card-header">
                    <h4 class="text-center">Login</h4>
                </div> -->
                <div class="card-body">
                    <form method="post">
                    	<?php if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                    			//display_errors($_SESSION['error']);
                    	} ?>
                        <div class="form-group">
                            <label for="username">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Enter Email" name="email" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block" name="submit">Login</button>

                        <p> Don't have an account? <a href="signup.php" class="link"> Sign Up</a></p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</section>

<?php   include 'includes/footer.php' ?>
