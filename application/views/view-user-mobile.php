
    <html>
    <head>
        

        <script src="<?= base_url(); ?>js/vendor/modernizr-2.6.1-respond-1.1.0.min.js"></script>
    </head>
    <body>
      


        <div class="row-fluid">
            <div class="row">
                <div class="heading-section col-md-12 text-center">
                    <h4>Tracking <?php echo ' '.$username.' '; ?> </h4>
                    <input type="hidden" id="username" name="username" value="<?=$username?>"/>
                </div> <!-- /.heading-section -->
            </div> <!-- /.row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="googlemap-wrapper">
                        <div id="map_canvas_locations" class="map-canvas"></div>
                    </div> <!-- /.googlemap-wrapper -->
                </div> <!-- /.col-md-12 -->
            </div> <!-- /.row -->
          
        </div> <!-- /.container -->
        <div id="footer">

        </div> <!-- /#footer -->

<!--<script type="text/javascript" src="js/jquery.min.js"></script> -->
        <script src="<?= base_url(); ?>js/vendor/jquery-1.11.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="<?= base_url(); ?>js/vendor/jquery-1.11.0.min.js"><\/script>')</script>
        <script src="<?= base_url(); ?>js/bootstrap.js"></script>
        <script src="<?= base_url(); ?>js/plugins.js"></script>
        <script src="<?= base_url(); ?>js/main.js"></script>
        <script type="text/javascript"
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBSr836clPDtPAsp3iW0aE3rhcnKhsuPdE">
        </script>

     

        <?php if(is_array($locations) && count($locations) ) {
						           //var_dump($locations);
            $lat = $locations[0]->lat;
           $lng= $locations[0]->lng;
		// $lat = '0.3417913';
        echo  "last posted".$created= $locations[0]->created;			
            }
	?>
       
    <script type="text/javascript">     
	
	var map;
        
   function initialize(){
    var mapOptions = {
        center: new google.maps.LatLng(<?php echo $lat;?>,<?php echo $lng;?>),
        zoom: 14  
       
    };
    map = new google.maps.Map(document.getElementById("map_canvas_locations"), mapOptions); 
	
     var myLatlng = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng; ?>);
	 var image = '<?= base_url(); ?>images/walking.png'; 
	 
		var marker = new google.maps.Marker({
			position: myLatlng ,
			map: map,
			title:"last <?php echo $created; ?>",
			 icon: image
		});                
	 
	   // 0.363189, 32.598064
      google.maps.event.addDomListener(window, 'load', initialize);
      
      }
    </script>



    <script type="text/javascript">     
	
    //The list of points to be connected
var map = null;
var infowindow = new google.maps.InfoWindow();
var bounds = new google.maps.LatLngBounds();
//The list of points to be connected
var markers = [

<?php if(is_array($locations) && count($locations) ) {
	foreach($locations as $loop){
	?>
    {
        "title": '<?php echo $loop -> created; ?>',
        "lat": '<?php echo $loop -> lat; ?>',
        "lng": '<?php echo $loop -> lng; ?>',
        "description":' <?php echo $loop ->username ; ?>'
    },
	
	<?php } } ?>
    
];


function initialize() {
    var mapOptions = {
        center: new google.maps.LatLng(<?php echo $lat;?>,<?php echo $lng;?>),
        zoom: 14 ,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    
} 
 google.maps.event.addDomListener(window,'load',initialize);
    </script>
	<script>
              
	   var form_data = { username: $('#username').val() };
				$.ajax({
					 type : 'POST',
					 url : "<?php echo base_url()?>index.php/user/movement" ,
                                          dataType: 'json',
                                           data: form_data,
					 success : function(data) {
                                            // console.log(data)
    var mapOptions = {
        center: new google.maps.LatLng(<?php echo $lat;?>,<?php echo $lng;?>),
        zoom: 14 ,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
 markers = JSON.parse(JSON.stringify(data));
						//console.log(markers[0].lat)
var path = new google.maps.MVCArray();
    var service = new google.maps.DirectionsService();

    var infoWindow = new google.maps.InfoWindow();
    map = new google.maps.Map(document.getElementById("map_canvas_locations"), mapOptions);
	map.setCenter(new google.maps.LatLng(<?php echo $lat;?>,<?php echo $lng;?>));
    var poly = new google.maps.Polyline({
        map: map,
        strokeColor: '#990000'
    });
    var lat_lng = new Array();

    for (var i = 0; i < markers.length; i++) {
        if ((i + 1) < markers.length) {
            var src = new google.maps.LatLng(parseFloat(markers[i].lat), 
                                             parseFloat(markers[i].lng));
            var des = new google.maps.LatLng(parseFloat(markers[i+1].lat), 
                                             parseFloat(markers[i+1].lng));
            service.route({
                origin: src,
                destination: des,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            }, function (result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                        path.push(result.routes[0].overview_path[i]);
                    }
                    poly.setPath(path);
                   // map.fitBounds(bounds);
                }
            });
        }
    }
  var myLatlng = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng; ?>);
	 var image = '<?= base_url(); ?>images/walking.png'; 
	 
		var marker = new google.maps.Marker({
			position: myLatlng ,
			map: map,
			title:"last <?php echo $created; ?>",
			 icon: image
		});   

					  //}
					  }
					  });
     </script>
    </body>
</html>