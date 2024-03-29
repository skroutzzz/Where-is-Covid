<?php 
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

    
    <?php
      require_once "config.php";
      
      $query = "SELECT * FROM mycovid";
      $query_run = mysqli_query($link, $query);

      $sql = "SELECT * FROM myvisit";
      $sql_run = mysqli_query($link, $sql);



    
    ?> 

        <table class="table table-bordered" id="dataTable" width="50%" cellspacing="0">
            <thead>
                <tr>
                    <th>Total number of covid cases</th>
                    <th>Total number of inserted visits</th>
                    
                  
                </tr>   
            </thead>
            <tbody>
           <?php $result_count = mysqli_num_rows($query_run);
                 $sql_count = mysqli_num_rows($sql_run)
            
            //echo  $total_website_views;
           
           
           ?>
                <tr>
                    <td><?php echo $result_count; ?></td>
                    <td><?php echo $sql_count; ?></td>
                   
                    
                    
                </tr>
               
            
            
           
            
            

            

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