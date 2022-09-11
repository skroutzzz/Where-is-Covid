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

            $k =trim($_POST['k']);

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
       
        <button class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="pure-button"
        >Get my location</button>
      </div>
      <?php include 'insertdatamap.php' ?>
  <body>
  <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
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
     var map = L.map('map').fitWorld();

   

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
    }).addTo(map);
      
    map.setView([37.983810,23.727539],6);




    $('#pure-button').on('click', function(){
    map.locate({setView: true, maxZoom: 15});
    });

    map.on('locationfound', onLocationFound);
    function onLocationFound(e) {
    console.log(e); 
    L.marker(e.latlng).addTo(map)
    .bindPopup("You are within 20 meters from this point")
    .openPopup();

          
        
          L.circle(e.latlng, 10, { color: "red" }).addTo(map);
       
      }
  

    /*
      map.locate({ setView: true, maxZoom: 13 });
      function onLocationFound(e) {

        var myloc = L.marker(e.latlng)
          .addTo(map)
          .bindPopup("You are within 20 meters from this point")
          .openPopup();

          
        
          L.circle(e.latlng, 10, { color: "red" }).addTo(map);
       
      }

      map.on("locationfound", onLocationFound);
      
      map.locate({ setView: false, maxZoom: 16 });
     */
      
       $.ajax(
    'insertdatamap.php',
    { 
      success: function(data) {

        

        var latlong = <?php echo json_encode($data,JSON_NUMERIC_CHECK); ?>;


        //console.log((Object.values(latlong[1])));
   
        var display_words = '<?php 
        if (isset($_POST['k']) && $_POST['k'] != ''){
        echo $poi_name; }
        ?>';
        console.log(display_words);
        
        const array_map=[];

        //var display_words = '';
       
        //console.log(display_words);


      for(var i = 0; i < latlong.length; i ++)
      { let result7 = ''
        Object.entries(latlong[i]).find(([key, value]) => {
        if (value === display_words) {
        result7 = value
          let result5 = '';
        Object.entries(latlong[i]).find(([key, value]) => {
        if (key === 'latitude') {
        result5 = value;
          }
        });
        console.log(result5);
        let result6 = '';
        Object.entries(latlong[i]).find(([key, value]) => {
        if (key === 'longtitude') {
        result6 = value;
          }
        });
        console.log(result6);

        
        marker = L.marker(Object.values([result5,result6]))
        .addTo(map)
        .bindPopup(result7)
        .openPopup();
        
        
        map.setView([result5,result6], 19);

        
        for ( var k = 0; k < latlong.length; k ++) { 
          let result1 = '';
          Object.entries(latlong[k]).find(([key, value]) => {
          if (key === 'latitude') {
          result1 = value;
            }
          });
           console.log(result1);
          let result2 = '';
          Object.entries(latlong[k]).find(([key, value]) => {
          if (key === 'longtitude') {
          result2 = value;
            }
          });
          let result3 = '';
          Object.entries(latlong[k]).find(([key, value]) => {
          if (key === 'poi_name') {
          result3 = value;
            }
          });
           console.log(result2);
         array_map[k] = new L.marker(Object.values([result1,result2]))
        .addTo(map)
        .bindPopup(result3 + '<br/><button type="button" class="btn btn-primary btn-icon-split">Click for more</button>');
       console.log((Object.values(latlong[k])));
       //btn btn-primary sidebar-open-button
      
       }

        //map.flyTo(setView(result5,result6));
       // console.log((Object.values(latlong[i])));
          }

        });
      }
    },
      error: function() {
        alert('There was some error performing the AJAX call!');
      }
   }
      );

    </script>
    </body>

    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- End of Main Content -->
  <script>
      

    
      
    </script>

<?php 

 include('includes/footer.php');
 include('includes/scripts.php'); 


?>