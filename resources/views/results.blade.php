
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Woofpack </title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
        <script src="http://maps.google.com/maps/api/js?key=AIzaSyAHShDo_C4WnrDy7Ssqr5ZRn2DDolRGg8A&libraries=places"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script>
/* script */
function initialize() {
   var latlng = new google.maps.LatLng(-28.5355161,77.39102649999995);
    var map = new google.maps.Map(document.getElementById('map'), {
      center: latlng,
      zoom: 13
    });
    var marker = new google.maps.Marker({
      map: map,
      position: latlng,
      draggable: true,
      anchorPoint: new google.maps.Point(0, -29)
   });
    var input = document.getElementById('searchInput');
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    var geocoder = new google.maps.Geocoder();
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    var infowindow = new google.maps.InfoWindow();
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }

        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        bindDataToForm(place.formatted_address,place.geometry.location.lat(),place.geometry.location.lng());
        infowindow.setContent(place.formatted_address);
        infowindow.open(map, marker);

    });
    // this function will work on marker move event into map
    google.maps.event.addListener(marker, 'dragend', function() {
        geocoder.geocode({'latLng': marker.getPosition()}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
          if (results[0]) {
              bindDataToForm(results[0].formatted_address,marker.getPosition().lat(),marker.getPosition().lng());
              infowindow.setContent(results[0].formatted_address);
              infowindow.open(map, marker);
          }
        }
        });
    });
}
function bindDataToForm(address,lat,lng){
   document.getElementById('location').value = address;
   document.getElementById('lat').value = lat;
   document.getElementById('lng').value = lng;
}
google.maps.event.addDomListener(window, 'load', initialize);
</script>
       <style >

         .navbar-nav>li>a:hover {
   background-color:transparent;

}

         .navbar-nav>li>a:active {
   background-color:transparent;

}

body::-webkit-scrollbar-track
{
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  border-radius: 10px;
  background-color: #F5F5F5;
}

.navbar-default .navbar-nav>.open>a, .navbar-default .navbar-nav>.open>a:focus, .navbar-default .navbar-nav>.open>a:hover {
    color: #555;
    background-color: transparent;
}

  .item-block header img {
    width: 124px;
    margin-right: 30px;
    float: left;
}


<style>
    .login-page {
    background-color: #e5e7ed;
}

.login-block{

  padding: 60px 0px;
}

.login-block h1 {
    font-size: 30px;
    margin-bottom: 20px;
    margin-top: 20px;
}

.nav-on-header .navbar {
    position: absolute;
    margin-top: 0px ! important;
    background-color: #DA4C33  ! important;
    margin-bottom: 50px;
}


  	
    	#mymap {
       
      		border:1px solid #cdcdcd;
      		width: 100%;
      		height:80vh;
    	}

      .item-block {
        margin-top: 0px;
    display: block;
    }

    .item-block header img {
    width: 124px;
    margin-right: 30px;
    float: left;
}
    </style>

    

 <div class="login-page">
  <div class="login-block">
<div class="container-fluid">
  <div class ="row">
    <div class ="col-sm-12">
        <h1 style ="">Search Results</h1>

      
    </div>
    
  </div>
    <div class="row">
       
      <div class ="col-sm-7">
      
  <div id="mymap"></div>
      </div>

      <div class ="col-sm-5">
      @foreach($airports as $airport)

         <p>This airport {{$airport->name}} is found in  {{$airport->city}}</p>
          
                @endforeach
                

                
              </a>
            </div>
        </div>


        
      </div>
  

  <script type="text/javascript">

    var locations = <?php print_r(json_encode($airports)) ?>;

    var mymap = new GMaps({
      el: '#mymap',
      lat: -26.270759,
      lng: 28.112268,
      zoom:7
    });

    $.each( locations, function( index, value ){
	    mymap.addMarker({
	      lat: value.latitude,
	      lng: value.longitude,
	      title: value.city,
	      click: function(e) {
	        alert('This is '+value.city);
	      }
	    });
   });

  </script>

</div>
</div>
</div>
</div>