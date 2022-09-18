<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../new_main/index.php");
    exit;
}
?>

<?php  
include('includes/header.php');
include('includes/navbar.php');
require_once "config.php";

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

      

      <!-- Topbar Search -->
      <form
        action="" method="POST" name="" id="form"
        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
      >
        <div class="input-group">
          <input
            type="text"
            name="k"
            class="form-control bg-light border-0 small"
            placeholder="Search for..."
            autocomplete="off"
            aria-label="Search"
            aria-describedby="basic-addon2"
          />
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit" name="search" id="submit" value="Search">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
        </div>
      </form>

      <?php 
          require_once "config.php";

          if (isset($_POST['k']) && $_POST['k'] != ''){

            $k = trim($_POST['k']);

            $display_words = "";

            $keywords = explode(' ', $k);
            foreach($keywords as $word){
              $query_string = " SELECT * FROM mypois WHERE poi_name LIKE '%" .$word. "%' ";
              
              $display_words .= $word." ";
            }

            $query = mysqli_query($link, $query_string);
            $result_count = mysqli_num_rows($query);

          

            if($result_count>0){


              
              echo 'Your search for <i> &nbsp;' .$display_words.' </i> <hr /><br />';
              echo $result_count;

              while($row = mysqli_fetch_assoc($query)){
                    $poi_name = $row['poi_name'];
                    $lat =  $row['latitude'];
                    $lng = $row['longtitude'];
                echo '<tr>
                      <td><h3>&nbsp;'.$poi_name.'</h3></td>
                      </tr>';
                
              }
                          
            }
            else
              echo 'No results found';
          }
        

      ?>


      

        <!-- Nav Item - Alerts -->
       

      
       
        <div class="topbar-divider d-none d-sm-block"></div>

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
              ><b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></span>
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
            <a class="dropdown-item" href="#">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
              Settings
            </a>
            <a class="dropdown-item" href="#">
              <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
              Activity Log
            </a>
            <div class="dropdown-divider"></div>
            <a
              class="dropdown-item"
              href="logout.php"
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

    <!-- Begin Page Content -->
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"></h1>

     


  
    <form class="form" id="myForm" >
      
    <input type="file" id="inpFile" class="btn btn-primary"/> 

      <button type="submit" id="btn" class="btn btn-primary">Upload File</button>
    </form>

   
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script>
      const myForm = document.getElementById("myForm");
      const inpFile = document.getElementById("inpFile");

      myForm.addEventListener("submit", (e) => {
        e.preventDefault();

        console.log(inpFile.files);

        var fileReader = new FileReader();
        var file;
        fileReader.readAsText(inpFile.files[0]);
        fileReader.onload = function () {
          file = JSON.parse(fileReader.result);
          console.log(file);
        };

        fileReader.onloadend = function () {
          var formData = JSON.stringify(file);
          $.ajax({
            url: "insertdata.php",
            dataType: "text",
            type: "POST",
            data: { formData: formData },
            success: function (response) {
              // window.location = "../index.php"
              console.log(response);
            },
            error: function (error) {
              console.log(error);
            },
          });
        };
      });
    </script>
    <div id="content"></div>
