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

<?php

// Include config file
require_once "config.php";

if(isset($_POST["covid_button"])){

    $covid_userid = $_SESSION["id"];
    
    $covid_date = $_POST["covid-date"];
    
   
    $sql = "SELECT cov_date FROM mycovid";

    $query = mysqli_query($link, $sql);
    $result_count = mysqli_num_rows($query);
    $data = mysqli_fetch_assoc($query);
   

    $difference = strtotime($covid_date)-strtotime($data["cov_date"]);
   

    if($difference/(24*60*60) > 14 ){

        $insert_covid = "INSERT INTO mycovid(cov_date, covid_userid)
        VALUES ('$covid_date', '$covid_userid');";
    
    
    
    try {
    
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $insert_covid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
       
       
        
        
    }
    catch (Exception $err) {
 
        die;
    }

    }
    
   

}

?>



<?php

// Include config file
require_once "config.php";

if(isset($_POST["visit_button"])){

  
    $visit_userid = $_SESSION["id"];
    date_default_timezone_set("Europe/Athens");
    $visit_timestamp = date_create()->format('Y-m-d H:i:s');

    $visit_poiid = 'ChIJ4bvbRlU3XhMRizrDqc9I6fU';
    
   
  
        $insert_visit = "INSERT INTO myvisit(visit_userid, visit_poiid, visit_timestamp)
        VALUES ('$visit_userid', '$visit_poiid', '$visit_timestamp');";
    
    
    
    try {
    
        $stmt = mysqli_stmt_init($link);
        mysqli_stmt_prepare($stmt, $insert_visit);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
       
       
       
        
        
    }
    catch (Exception $err) {
 
        die;
    }

    
    
   

}

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
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>

      <!-- COVID -->

      <div class="my-2"></div>
                                    <button class="btn btn-danger btn-icon-split" id="covid-case" data-toggle="modal" data-target="#covid_case">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                        <span class="text">I have COVID-19</span>
                                    </button>

                                    <div class="my-2"></div>
<div class="modal fade" id="covid_case" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Covid Date</h5>
        <button type="button" class="btn btn-danger btn-icon-split close " data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="index.php" name="covidForm" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label> Date of Covid </label>
                <input type="date" name="covid-date" required class="form-control" placeholder="Enter Date">
            </div>
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="covid_button" class="btn btn-primary">Save</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- VISIT -->

<div class="my-2"></div>
<div class="modal fade" id="visit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Visit</h5>
        <button type="button" class="btn btn-danger btn-icon-split close " data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="index.php" name="visitForm" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label> Have you visited this place? </label>
                
            </div>
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            <button type="submit" name="visit_button" class="btn btn-primary">Yes</button>
        </div>
      </form>

    </div>
  </div>
</div>
       
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

    // $('#visit-button').on('click', function(){
    //       alert("The paragraph was clicked.");
    // });


    $('#pure-button').on('click', function(){
    map.locate({setView: true, maxZoom: 15});
    });

    map.on('locationfound', onLocationFound);
    function onLocationFound(e) {
    //console.log(e); 
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

       
        
        var redIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
	      iconSize: [25, 41],
	      iconAnchor: [12, 41],
	      popupAnchor: [1, -34],
	      shadowSize: [41, 41]
        });

        var blueIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
	      iconSize: [25, 41],
	      iconAnchor: [12, 41],
	      popupAnchor: [1, -34],
	      shadowSize: [41, 41]
        });

        var yellowIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
         });

        var icon1 = '';

        var latlong = <?php echo json_encode($data,JSON_NUMERIC_CHECK); ?>;


        //console.log((Object.values(latlong[1])));
   
        var display_words = '<?php 
        if (isset($_POST['k']) && $_POST['k'] != ''){
        echo $poi_name; }
        ?>';
        //console.log(display_words);
        
        const array_map=[];
        var icon1 = '';

        //var display_words = '';
       
        //console.log(display_words);


      for(var i = 0; i < latlong.length; i ++)
      { let result7 = ''
        Object.entries(latlong[i]).find(([key, value]) => {
        if (value === display_words) {
        result7 = value;
          let result5 = '';
        Object.entries(latlong[i]).find(([key, value]) => {
        if (key === 'latitude') {
        result5 = value;
          }
        });
        //console.log(result5);
        let result6 = '';
        Object.entries(latlong[i]).find(([key, value]) => {
        if (key === 'longtitude') {
        result6 = value;
          }
        });
        let result9 = '';	
        Object.entries(latlong[i]).find(([key, value]) => {	
        if (key === 'poi_id') {	
        result9 = value;	
        //console.log(result9);	
          }	
        });

        
       
        
        for ( var k = 0; k < latlong.length; k ++) { 
          let result1 = '';
          Object.entries(latlong[k]).find(([key, value]) => {
          if (key === 'latitude') {
          result1 = value;
            }
          });
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
          let result11 = '';	
          Object.entries(latlong[k]).find(([key, value]) => {	
          if (key === 'poi_id') {	
          result11 = value;	
          //console.log(result11);	
            }	
          });	




       ///POPULARTIMES
        let result10 = '';
        Object.entries(latlong[k]).find(([key, value]) => {
        if (key  === 'populartimes') {
        result10 = value;
        var date = new Date();
        var hour = date.getHours();
        var minutes = date.getMinutes()
        var day = date.getDay();
        var res = JSON.parse(result10);
        //console.log(res);
        //console.log(res[day-1].data[hour]);
        if(res[day-1].data[hour]>66)
          {icon1 = redIcon;}
        else if(res[day-1].data[hour]>33)
        {icon1 = yellowIcon;}
        else {icon1 = blueIcon;}

        marker = L.marker(Object.values([result5,result6]))
        .addTo(map)
        .bindPopup(result7)
        .on('click', onClick)
        .openPopup();
        
        
        map.setView([result5,result6], 19);

        
           }
        }); 

         marker = new L.marker(Object.values([result1,result2]) ,{icon: icon1})
        .addTo(map)
        .on('click', onClick)
        .bindPopup(result3);
        icon1='';



        function onClick() {
          if (confirm('Are you sure you want to save this thing into the database?')) {

            var result = prompt("Visit Estimation");  
                                           
                 var db = result11;
                    if ($(db).val() != 0) {
                       $.post("button-insert.php", {
                          variable:db,
                          var2: result
                             }, function(data1) {
                            if (data1 != "") {
                           alert('We sent Jquery string to PHP : ' + data1);
                           }
                                  });
                                  }


            console.log('Thing was saved to the database.');
          } else {
            // Do nothing!
            console.log('Thing was not saved to the database.');
          }
        }
       
      
       }
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