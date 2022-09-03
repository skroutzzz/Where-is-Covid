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
      <button
        id="sidebarToggleTop"
        class="btn btn-link d-md-none rounded-circle mr-3"
      >
        <i class="fa fa-bars"></i>
      </button>

      <!-- Topbar Search -->
      <form
        action="" method="GET" name="" 
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
            <button class="btn btn-primary" type="submit" name="search" value="Search">
              <i class="fas fa-search fa-sm"></i>
            </button>
          </div>
        </div>
      </form>

      <?php 
          require_once "config.php";

          if (isset($_GET['k']) && $_GET['k'] != ''){

            $k =trim($_GET['k']);

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

                echo '<tr>
                      <td><h3>&nbsp;'.$row['poi_name'].'</h3></td>
                      </tr>';
                
              }
                          
            }
            else
              echo 'No results found';
          }
        

      ?>

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
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <a
          href="#"
          class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
          ><i class="fas fa-download fa-sm text-white-50"></i> Generate
          Report</a
        >
      </div>

      <div id="map">
      <a
        href="https://www.maptiler.com"
        style="position: absolute; left: 10px; bottom: 10px; z-index: 999"
        ><img
          src="https://api.maptiler.com/resources/logo.svg"
          alt="MapTiler logo"
      /></a>
    </div>
    <p>
      <a href="https://www.maptiler.com/copyright/" target="_blank"
        >&copy; MapTiler</a
      >
      <a href="https://www.openstreetmap.org/copyright" target="_blank"
        >&copy; OpenStreetMap contributors</a
      >
    </p>
    <script>
      var map = L.map("map").setView([0, 0], 1);
      L.tileLayer(
        "https://api.maptiler.com/maps/streets/{z}/{x}/{y}.png?key=m4UDU1L0NSzWbDH7I0Ir",
        {
          tileSize: 512,
          zoomOffset: -1,
          minZoom: 15,
          attribution:
            '\u003ca href="https://www.maptiler.com/copyright/" target="_blank"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href="https://www.openstreetmap.org/copyright" target="_blank"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e',
          crossOrigin: true,
        }
      ).addTo(map);

      map.locate({ setView: true, maxZoom: 16 });
      function onLocationFound(e) {
        var radius = e.accuracy;

        L.marker(e.latlng)
          .addTo(map)
          .bindPopup("You are within 20 meters from this point")
          .openPopup();

        L.circle(e.latlng, 10, { color: "red" }).addTo(map);
      }

      map.on("locationfound", onLocationFound);

      marker.bindPopup("<b> Hey there! </b><br>I am a marker.").openPopup();
      circle.bindPopup("I am a circle");
      polygon.bindPopup("I am polygon");
    </script>
      <!-- Content Row -->

    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- End of Main Content -->


<?php 

 include('includes/footer.php');
 include('includes/scripts.php'); 


?>