<script src="<?=base_url('theme/js/jquery-2.1.4.js')?>"></script>
<script>
var q = jQuery.noConflict();
var selected = ["grocery_or_supermarket"];

q( document ).ready(function( q ) {
    q('.map-legenda').change(function() {
        var selected = [];
        q.each(q('.map-legenda input:checked'), function(a,b) {
            selected.push(q(b).val());
        });
        console.log(selected);
        initialize(selected);
    });
});
</script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA8FXHgT4Z5or6oMD79gMVjGXxCnxTmL1c&libraries=places"></script>
<script>
var map;
var infowindow;

function initialize(selected) {
  var _lat = "10.770527";
  var _long = "106.684417";

  var home = new google.maps.LatLng(_lat, _long);

  map = new google.maps.Map(document.getElementById('map_canvas'), {
    center: home,
    zoom: 15
  });

  var request = {
    location: home,
    radius: 750,
    types: selected
  };

  infowindow = new google.maps.InfoWindow();
  var service = new google.maps.places.PlacesService(map);
  service.nearbySearch(request, callback);

  var marker_home = new google.maps.Marker({
    map: map,
    position: home,
    icon: '<?=base_url()?>theme/images/icons/covers.png'
  });
}

function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      createMarker(results[i]);
    }
  }
}

var grocery_icon = '<?=base_url()?>theme/images/icons/grocerystore.png';
var school_icon = '<?=base_url()?>theme/images/icons/school.png';
var gym_icon = '<?=base_url()?>theme/images/icons/gym.png';
var treinstation_icon = '<?=base_url()?>theme/images/icons/treinstation.png';
var bakery_icon = '<?=base_url()?>theme/images/icons/bakery.png';
var bus_station_icon = '<?=base_url()?>theme/images/icons/busstation.png';
var convenience_store_icon = '<?=base_url()?>theme/images/icons/conv_store.png';
var movie_theater_icon = '<?=base_url()?>theme/images/icons/bios.png';
var park_icon = '<?=base_url()?>theme/images/icons/park.png';
var parking_icon = '<?=base_url()?>theme/images/icons/parking.png';

function createMarker(place) {
  var custom_icon;
  if(place.types.indexOf('grocery_or_supermarket') != -1) {
    custom_icon = grocery_icon;
  } else if(place.types.indexOf('gym') != -1) {
    custom_icon = gym_icon;
  } else if(place.types.indexOf('train_station') != -1) {
    custom_icon = treinstation_icon;
  } else if(place.types.indexOf('school') != -1) {
    custom_icon = school_icon;
  } else if(place.types.indexOf('bakery') != -1) {
    custom_icon = bakery_icon;
  } else if(place.types.indexOf('bus_station') != -1) {
    custom_icon = bus_station_icon;
  } else if(place.types.indexOf('convenience_store') != -1) {
    custom_icon = convenience_store_icon;
  } else if(place.types.indexOf('movie_theater') != -1) {
    custom_icon = movie_theater_icon;
  } else if(place.types.indexOf('park') != -1) {
    custom_icon = park_icon;
  } else if(place.types.indexOf('parking') != -1) {
    custom_icon = parking_icon;
  }

  var marker = new google.maps.Marker({
    map: map,
    position: place.geometry.location,
    title: place.name,
    icon: custom_icon
  });

  google.maps.event.addListener(marker, 'click', function() {
    infowindow.setContent(place.name);
    infowindow.open(map, this);
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
<style>
#map_canvas{
    width:1000px;
    height:400px;
}
</style>
<div id="map_canvas"></div>
<br/>
<ul class="map-legenda">
  <li class="woning">
    <img width="32" height="32" alt="Woning" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/covers.png">
    Woning
  </li>
  <li class="supermarkt">
    <img width="32" height="32" alt="Supermarkt" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/grocerystore.png">
    Supermarkt<input type="checkbox" name="supermarkt" value="grocery_or_supermarket" checked>
  </li>
  <li class="parkeerplaats">
    <img width="32" height="32" alt="" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/parking.png">
    Parking<input type="checkbox" name="parkeerplaats" value="parking">
  </li>  
  <li class="parkeerplaats">
    <img width="32" height="32" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/parking.png">
   parking <input type="checkbox" name="parkeerplaats" value="parking">
  </li>  
  <li class="fitness">
    <img width="32" height="32" alt="Fitness" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/gym.png">
   fitness <input type="checkbox" name="fitness" value="gym">
      </li> 
    <li class="school">
    <img width="32" height="32" alt="School" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/school.png">
   school <input type="checkbox" name="school" value="school">
      </li>  
      <li class="bakkerij">
        <img width="32" height="32" alt="" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/bakery.png">
     bakery  <input type="checkbox" name="bakkerij" value="bakery">
      </li>
      <li class="busstation">
        <img width="32" height="32" alt="" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/busstation.png">
     bus_station  <input type="checkbox" name="busstation" value="bus_station">
      </li>
      <li class="park">
        <img width="32" height="32" alt="" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/park.png">
   park   <input type="checkbox" name="park" value="park">
      </li>
      <li class="bios">
        <img width="32" height="32" alt="" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/bios.png">
  movie_theater<input type="checkbox" name="bios" value="movie_theater">
      </li>
      <li class="buurtwinkel">
        <img width="32" height="32" alt="" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/conv_store.png">
      convenience_store  <input type="checkbox" name="buurtwinkel" value="convenience_store">
      </li>
      <li class="treinstation">
        <img width="32" height="32" alt="Trein" src="<?php base_url("template_url"); ?>/lib/images/maps_icons/treinstation.png">
     train_station  <input type="checkbox" name="treinstation" value="train_station">
  </li>
</ul>