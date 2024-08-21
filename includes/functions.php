<?php
$connection = mysqli_connect('localhost', 'root', '', 'message');


function register_user( $email, $password, $first_name, $last_name, $role) {
    global $connection;

    // Sanitize input data to prevent SQL injection.
    //$username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
    $first_name = mysqli_real_escape_string($connection, $first_name);
    $last_name = mysqli_real_escape_string($connection, $last_name);
    $role = mysqli_real_escape_string($connection, $role);

    // Hash the password securely using PHP's password_hash() function.
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email is already registered.
    $query = "SELECT * FROM Users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if (!$result || mysqli_num_rows($result) > 0) {
        $_SESSION['error'] = "Email already registered.";
        return false;
    }

    // Insert the user data into the database.
    $query = "INSERT INTO Users ( email, password, first_name, last_name, role) 
              VALUES ( '$email', '$hashed_password', '$first_name', '$last_name', '$role')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // Registration successful.
        $_SESSION['success'] = "Registration successful. You can now log in.";
        return true;
    } else {
        // Registration failed.
        $_SESSION['error'] = "Registration failed. Please try again later.";
        return false;
    }
}
function redirect($url){
    if (!headers_sent()) {
        header("Location: {$url}");
    }
    else{
        echo '<script>window.location.href="' . $url . '"</script>';
    }
    exit;
}
function validate_input($input, $type) {
    // Define regular expressions for different types
    $regex_patterns = array(
        'email' => '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
        'username' => '/^[A-Za-z0-9_]{3,20}$/',
        'password' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/'
        // You can add more types and their corresponding regex patterns as needed
    );

    // Check if the type is defined in the regex patterns
    if (!array_key_exists($type, $regex_patterns)) {
        return false; // Invalid type
    }

    // Check if the input is not null and matches the regex pattern
    if ($input !== null && preg_match($regex_patterns[$type], $input)) {
        return true; // Valid input
    } else {
        return false; // Invalid input
    }
}
function display_errors($error_messages) {
    if (is_array($error_messages) && count($error_messages) > 0) {
        
        echo '<ul>';
        foreach ($error_messages as $error) {
            echo '<li class= "text-danger">' . $error . '</li>';
        }
        echo '</ul>';
        
    } elseif (!empty($error_messages)) {
        echo '<p class= "text text-danger" role="alert">';
        echo $error_messages;
        echo '</p>';
    }
}
function login_user($email, $password) {
    global $connection;

    // Sanitize the email to prevent SQL injection.
    $email = mysqli_real_escape_string($connection, $email);

    // Fetch the user record based on the provided email.
    $query = "SELECT * FROM Users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if (!$result || mysqli_num_rows($result) !== 1) {
        $_SESSION['error'] = "Invalid email or password.";
        return false;
    }

    // Get the user data from the database.
    $user = mysqli_fetch_assoc($result);

    // Verify the password using password_verify().
    if (password_verify($password, $user['password'])) {
        // Password is correct, user is authenticated.
        $_SESSION['success'] = "Login successful.";
        $_SESSION['user_id'] = $user['user_id']; // Store user ID in session
        $_SESSION['role'] = $user['role']; // Store user ID in session
        return true;
    } else {
        // Password is incorrect.
        $_SESSION['error'] = "Invalid email or password.";
        return false;
    }
}
function dnd($data){
    echo '<pre>';
        var_dump($data);
    echo '</pre>';
    die;
}

function displayErrors($errors){
    echo '<ul class="errors">';
            foreach ($errors as $error) {
                echo "<li> {$error} </li>";
            }
    echo '</ul>';
}

function sanitize($dirty){
    $clean = htmlentities($dirty, ENT_QUOTES, "UTF-8");
    return trim($clean);
}

function cleanPost($post){
    $clean = [];
    foreach ($post as $key => $value) {
        $clean[$key] = sanitize($value);
    }
    return $clean;
}

//function for persisting form data
function persist($array, $key, $default = ""){
    if (!isset($array[$key]) || empty($array[$key])) {
        return $default;
    }else{
        return $array[$key];
    }
}
