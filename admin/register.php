<?php
session_start();
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $email =$confirm_password =  $admin_id = "";
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
        $sql = "SELECT user_id FROM myUSERS WHERE user_email = ?";
        
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
                echo "Oops! Something went wrong. Please try again later. 1";
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
        $sql = "SELECT user_id FROM myUSERS WHERE user_username = ?";
        
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
                echo "Oops! Something went wrong. Please try again later. 2";
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
        $sql = "INSERT INTO myUSERS (user_username, user_password, user_email, admin_id) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_username, $param_password, $param_email, $param_admin_id);
            
            // Set parameters
            $param_email = $email;
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $param_admin_id = 1;
            // $param_admin_id = $admin_id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Oops! Something went wrong. Please try again later. 3";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection 
    mysqli_close($link);
}
?>

<?php  
include('includes/header.php');
include('includes/navbar.php');

?>


<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
  <!-- Main Content -->
  <div id="content">
    <!-- Topbar -->
    <nav
      class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"
    >
      <!-- Sidebar Toggle (Topbar) -->
      <button
        id="sidebarToggleTop"
        class="btn btn-link d-md-none rounded-circle mr-3"
      >
        <i class="fa fa-bars"></i>
      </button>

      <!-- Topbar Search -->
      <form
        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
      >
        <div class="input-group">
          <input
            type="text"
            class="form-control bg-light border-0 small"
            placeholder="Search for..."
            aria-label="Search"
            aria-describedby="basic-addon2"
          />
          <div class="input-group-append">
            <button class="btn btn-primary" type="button">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
        </div>
      </form>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
        <li class="nav-item dropdown no-arrow d-sm-none">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="searchDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="fas fa-search fa-fw"></i>
          </a>
      

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="userDropdown"
            role="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"
              ><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></span
            >
            <img
              class="img-profile rounded-circle"
              src="img/undraw_profile.svg"
            />
          </a>
          <!-- Dropdown - User Information -->
          <div
            class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="userDropdown"
          >
         
            <div class="dropdown-divider"></div>
            <a
              class="dropdown-item"
              href="#"
              data-toggle="modal"
              data-target="#logoutModal"
            >
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- End of Topbar -->


<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Admin Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="signupForm" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label> Username </label>
                <input type="text" name="username" required class="form-control" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required class="form-control checking_email" placeholder="Enter Email">
                <small class="error_email" style="color: red;"></small>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required class="form-control" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required class="form-control" placeholder="Confirm Password">
            </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="signup_button" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>



<div class="container-fluid">

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Admin Profile
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addadminprofile">
            Add Admin Profile 
            </button>
        </h6>
    </div>

    <div class="card-body">
    <div class="table-responsive">


    <?php
      require_once "config.php";
      $query = "SELECT * FROM myusers WHERE admin_id = 1";
      $query_run = mysqli_query($link, $query);

    
    ?> 

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>EDIT</th>
                    <th>DELETE</th>
                </tr>   
            </thead>
            <tbody>
            <?php 
            if(mysqli_num_rows($query_run)>0)
            {
              while($row = mysqli_fetch_assoc($query_run))
              {
                ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['user_username']; ?></td>
                    <td><?php echo $row['user_email']; ?></td>
                    <td><?php echo $row['user_password']; ?></td>
                    
                    <td>
                      <form action="" method="POST">
                      <button type="submit" class="btn btn-success">EDIT</button>
                      </form>
                    </td>
                    <td>
                    <button type="submit" class="btn btn-danger">DELETE</button>
                    </td>
                </tr>
                <?php 
              }
            }
            
            else{
              echo "No Record found";
            }
            
            

            ?>

            </tbody>
        </table>
    </div>
</div>
</div> <!-- PROSOXI AYTO -->

</div>


</div>

<?php 

 include('includes/footer.php');
 include('includes/scripts.php'); 


?>