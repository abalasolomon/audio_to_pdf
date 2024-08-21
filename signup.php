<?php  

//session_start();
 include 'includes/header.php';
 // Include your functions



if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    //$username = mysqli_real_escape_string($connection, $_POST['username']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $first_name = mysqli_real_escape_string($connection, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($connection, $_POST['last_name']);
    $role = 'user';

          if (!preg_match("/^[a-zA-Z]*$/", $last_name) || !preg_match("/^[a-zA-Z]*$/", $first_name)) {
                $_SESSION['error'] = "Please enter valid names";

            redirect("signup.php"); // Redirect to the login page after successful registration


    }else{
        // Register the user
        if (register_user( $email, $password, $first_name, $last_name, $role)) {
            redirect("signin.php"); // Redirect to the login page after successful registration
            exit();
        } else{
        $_SESSION['error'] = "Please enter valid credentials";
            redirect("signup.php"); // Redirect to the login page after successful registration

        }
    }
}

?>


<section class="breadcrumbs">
  <div class="container">

    <div class="d-flex justify-content-between align-items-center">
      <h2> Sign Up</h2>
      
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
                        <div class="form-group">
                            <label for="first_name">First name</label>
                            <input type="text" class="form-control" id="first_name" placeholder="Enter first name" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last name</label>
                            <input type="text" class="form-control" id="last_name" placeholder="Enter last name" name="last_name" required>
                        </div>
                        <div class="form-group">
                            <label for="username">Email</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter Email" name="email" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Sign up</button>
                        <p> Already have an account? <a href="signin.php" class="link"> Sign in</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</section>

<?php   include 'includes/footer.php' ?>
