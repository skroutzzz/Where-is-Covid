<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $email =$confirm_password = "";
$username_err = $password_err = $email_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    
    //Validate Email

    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter your email.";
    } elseif(!preg_match('/^[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', trim($_POST["email"]))){
        $email_err = "Try another email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT userID FROM Users WHERE userMail = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT userId FROM Users WHERE userUsername = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    


     // Validate password


     if(empty(trim($_POST["password"]))){
         $password_err = "Please enter a password.";     
     }  
        elseif(strlen(trim($_POST["password"])) < 8 ){
             $password_err = "Password must have at least 8 characters";
    }
      elseif(!preg_match("#[a-z]+#",$_POST["password"])){
            $password_err = "Password should include at least one low letter";
    } 
        elseif(!preg_match("#[A-Z]+#",$_POST["password"])){
            $password_err = "Password should include at least one upper letter";
    }
        elseif(!preg_match("#[0-9]+#",$_POST["password"])){
            $password_err = "Password should include at least one number";
    }
        elseif(!preg_match('@[#$*&!]@', $_POST["password"])){
            $password_err = "Password should include at least one special character";
    }
    else{
         $password = trim($_POST["password"]);
     }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO Users (userUsername, userPassword, userMail) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email);
            
            // Set parameters
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
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
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Merriweather&family=Poppins:wght@300&family=Roboto&display=swap"
      rel="stylesheet"
    />
    <link href = "signup.css" rel = "stylesheet"
    !important/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



    </head>
  <body>
    <div class="container">
      <!-- section-left-start -->

      <div class="container-left">
        <div class="wrapper-left">
          <div class="part-one">
            <h3>Where is Covid</h3>
            <p>Sign up for an account</p>
          </div>
         <!--action="post"  method="post" enctype="multipart/form-data" onsubmit="AJAXSubmit(this); return false;"-->
           <div class="input_signup_form"  
          > 
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="signupForm" method="POST">
             
              <label for="" class="<?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>"> Email </label>
              <span class="invalid-feedback"><?php echo $email_err; ?></span>
              <input
                class="input_field"
                class="form-control"
                type="username"
                placeholder="Ιnput your Email here"
                id="signupFormEmail"
                name="email" required
              />
              
              
              <label for="" class="username <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>"> Username </label>
              <span class="invalid-feedback"><?php echo $username_err; ?></span>
              <input
                class="input_field"
                class="form-control"
                type="username"
                placeholder="Ιnput your username here"
                id="signupFormUsername"
                name="username" required
              />
              <label for="" class="pass <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>"> Password </label>
              <span class="invalid-feedback"><?php echo $password_err; ?></span>
              <input
                class="input_field"
                class="form-control"
                type="password"
                placeholder="Ιnput your password here"
                name="password" required
                id="signupFormPassword"
              />
              
              <label for="" class="pass <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>"> Confirm Password </label>
              <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
              <input
                class="input_field"
                class="form-control"
                type="password"
                placeholder="Ιnput your password here"
                name="confirm_password" required
                id="signupFormPassword"
              />
            <div class="buttons">
            <button class="signup_button" name="signup_button" type="submit">Sign up</button>
              <a href="/synalies_askhsh/php/register.php">
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
          <div class="login">
            <a href="index.php">Already have an account? 
              Login </a>
          </div>
        </div>
      </div>
      <!-- section-left-end -->
    </div>
  </body>
</html>