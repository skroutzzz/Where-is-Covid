<?php
// Initialize the session
session_start();
 
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
          <!-- Dropdown - Messages -->
          <div
            class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
            aria-labelledby="searchDropdown"
          >
            <form class="form-inline mr-auto w-100 navbar-search">
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
          </div>
        </li>


      
   
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

    <form action="Profile_Update.php" method="post">
  <div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Change User Data</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" name="signupForm" method="POST">
        
          <div class="modal-body">

              <div class="form-group">
                  <label> Change Username </label>
                  <input type="text" name="username"  >
              </div>
              <div class="form-group">
                  <label> Change Password</label>
                  <input type="password" name="password"  >
              </div>
              <div class="form-group">
                  <label>Confirm Password</label>
                  <input type="password" name="confirm_password"  >
              </div>


          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" name="edit_button" class="btn btn-primary">Save</button>
              
          </div>
        </form>

      </div>
    </div>
  </div>
</form>



<div class="container-fluid">




    <div class="card-body">
    <div class="table-responsive">


    <?php
      require_once "config.php";
      //$user_now = echo htmlspecialchars($_SESSION["username"]);
      $query = "SELECT * FROM myvisit 
      INNER JOIN mypois
      ON myvisit.visit_poiid = mypois.poi_id 
      WHERE visit_userid ='{$_SESSION['id']}'";

      $query_run = mysqli_query($link, $query);
      
      $query1 = "SELECT * FROM myvisit 
      INNER JOIN mypois
      ON myvisit.visit_poiid = mypois.poi_id 
      LEFT JOIN mycovid
      ON myvisit.visit_id = mycovid.covid_id
      WHERE visit_userid !='{$_SESSION['id']}'";

      $query_run1 = mysqli_query($link, $query1);

      $array = array();
      $array1 = array();

      while($row = mysqli_fetch_assoc($query_run)){

        // add each row returned into an array
        $array[] = $row;
      
        // OR just echo the data:
        //echo '<pre>'; print_r($array); echo '</pre>';
      
      }
      
      // debug:
      while($row1 = mysqli_fetch_assoc($query_run1)){

        // add each row returned into an array
        $array1[] = $row1;
      
        // OR just echo the data:
        //echo '<pre>'; print_r($array[0]['visit_id']); echo '</pre>';
      
      }
      //  echo '<pre>'; print_r($array); echo '</pre>';
      //  echo '<pre>'; print_r($array1); echo '</pre>';


    ?> 

        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Dangerous Places</th>
                    <th>Time</th>
                    <th>Address</th>
                </tr>   
            </thead>
            <tbody>
            <?php 
        
        
       
        if(sizeof($array1)!=0){
              for ($i = 0; $i <= sizeof($array)-1; $i++)
              { $l=1;
                
                for ($x = 0; $x <= sizeof($array1)-1; $x++){

                $difference = strtotime($array[$i]['visit_timestamp']) - strtotime($array1[$x]['visit_timestamp']);
                $difference1 = round($difference/(24*60*60),1);
                $dif1 = $difference/(60*60) + 2;
                $dif2 = $difference /(60*60) - 2;
                echo "<script>console.log('{$difference}' );</script>"; 
                echo "<script>console.log('{[$dif2]}');</script>"; 
                echo "<script>console.log('{[$dif1]}');</script>"; 

                IF($array[$i]['visit_poiid']===$array1[$x]['visit_poiid'] && $l===1 && $difference1<1 && $difference1>-6 && ( ($dif1<2 && $dif1>-2) || ($dif2<2 && $dif2>-2) ) ){
                          
                          echo '<tr>';
                          echo '<td><p style="color:#FF0000">';
                          echo $array[$i]['poi_name'];
                          echo ' - COVID CONFIRMED CASE<span>&#9888;</span></p></td>';
                          echo '<td>';
                          echo $array[$i]['visit_timestamp'];
                          echo '</td>';
                          echo '<td>';
                          echo $array[$i]['poi_address']; 
                          echo '</td>';
                          echo '</tr>';
                          $l=0;
                        }

                          

            
                        }
            }

          
          }


          ?> 

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                  <tr>
                      <th>All Visited Places</th>
                      <th>Time</th>
                      <th>Address</th>
                  </tr>   
              </thead>
              <tbody>
              <?php 
          
         
        
            
            for ($t = 0; $t <= sizeof($array)-1; $t++){
                            echo '<tr>';
                            echo '<td>';
                            echo $array[$t]['poi_name'];
                            echo '<td>';
                            echo $array[$t]['visit_timestamp'];
                            echo '</td>';
                            echo '<td>';
                            echo $array[$t]['poi_address']; 
                            echo '</td>';
                            echo '</tr>';
                            
          }
        
           

            ?>

            </tbody>
        </table>
    </div>
</div>
</div> <!-- PROSOXI AYTO -->

</div>

        </div>

</div>

<?php 

 include('includes/footer.php');
 include('includes/scripts.php'); 
?>