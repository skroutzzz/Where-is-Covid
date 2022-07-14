<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]); 
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT userId, userUsername, userPassword FROM users WHERE userUsername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Where is Covid</title>
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Merriweather&family=Poppins:wght@300&family=Roboto&display=swap"
      rel="stylesheet"
    />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href = "login.css" rel = "stylesheet"
    !important/>
    


    </head>
    <body>
    <div class="container">
      <!-- section-left-start -->

      <div class="container-left">
        <div class="wrapper-left">
          <div class="part-one">
            <h3>Where is Covid</h3>
            <p>Log into your account</p>
          </div>
         <!--action="post"  method="post" enctype="multipart/form-data" onsubmit="AJAXSubmit(this); return false;"-->
           <div class="input_login_form"  
          > 
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" value="<?php echo $username; ?>" name="loginForm" method="POST">
              <label for="" class="username <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>">Username </label>
              <i class="fas fa-user username"></i>
              <span class="invalid-feedback"><?php echo $username_err; ?></span>
              <input
                class="input_field"
                class="form-control"
                type="username"
                placeholder="Input your username here"
                id="loginFormUsername"
                name="username" required
              />
              
              <label for="" class="pass <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">Password </label>
              <i class="fas fa-lock pass"></i>
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
              <input
                class="input_field"
                class="form-control"
                type="password"
                placeholder="Input your password here"
                name="password" required
                id="loginFormPassword"
              />


            <div class="buttons">
            <button class="login_button" name="login_button" type="submit">Login</button>

            
            <!-- <button class="btn-two">
              <i class="fab fa-google"></i> Sign up with google
            </button> -->
          </div>
            </form>
          </div>
          
          <!-- <div class="check">
            <label for="privacy">
              I read and accept the User Agreement and <br />
              Privacy Policy.
              <input id="privacy" type="checkbox" />
              <span class="checkmark"></span>
            </label>
          </div> -->
          <div class="signup">
            <p>Do not have an account?</p>
            <a href="register.php"> Sign up </a>
          </div>
          <!-- <div class="hidden" name="signupSuccessMessage">Signup was succesful. </div>
        </div> -->
      </div>
      <!-- section-left-end -->
    </div>
  </body>
</html>


