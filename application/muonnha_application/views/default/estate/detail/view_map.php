
    <div id="listDistance">
        <label><input type="radio" name="radius" value="300" />300m</label>
        <label><input type="radio" name="radius" value="500" />500m</label>
        <label><input type="radio" name="radius" value="1000" />1000m</label>
        <label><input type="radio" name="radius" value="1500" />1500m</label>
        <label><input type="radio" name="radius" value="2000" />2000m</label>
    </div>
    <strong>Tiện ích:</strong>
    <div id="listUtility">
        <label><input class="utility" type="checkbox" name="Utility1" id="Utility1" value="restaurant" /> Nhà hàng</label>
        <label><input class="utility" type="checkbox" name="Utility2" id="Utility2" value="store" /> Cửa hàng</label>
         <label><input class="utility" type="checkbox" name="Utility3" id="Utility3" value="bank" /> Ngân hàng</label>
          <label><input class="utility" type="checkbox" name="Utility4" id="Utility4" value="church" /> Nhà thờ</label>
           <label><input class="utility" type="checkbox" name="Utility5" id="Utility5" value="atm" /> ATM</label>
    </div>
    <div id="map"></div>
    <div id="tableResult">
        
    </div>
    
    
    <script>
    var API_KEY = 'AIzaSyAx1LugN4iIuVoiCLVycaw5dO9Y5Lcqcr4';
      
      var map;
      var infowindow;

	   $(document).ready(function() {
       $('#listDistance input[type="radio"]').on('change', function() {
            var selected = [];
			$('.utility').change(function(){
    			
    			$.each($('.utility:checked'), function(a,b){
    				selected.push($(b).val());
    			})
    			console.log(selected);
    			initMap(selected, 1000);
    		})
            initMap(selected, this.value);
       }); 
       /*$('#listUtility input[type="checkbox"]').on('change', function(a,b) {
            var utility = "";
            $('#listUtility input[type="checkbox"]').each(function() {
                if(this.checked == true) utility += "'"+this.value + "',";
            });
            console.log(utility.substring(0, utility.length-1));
            initMap(utility.substring(0, utility.length-1), 500);
       });*/
		$('.utility').change(function(){
			var selected = [];
			$.each($('.utility:checked'), function(a,b){
				selected.push($(b).val());
			})
			console.log(selected);
			initMap(selected, 1000);
		})
    });
	  
      function initMap(Type, Radius) {
        var pyrmont = {lat: 10.770527, lng: 106.684417};
        var fromName = '376 Võ văn tần, phường 3';

        map = new google.maps.Map(document.getElementById('map'), {
          center: pyrmont,
          zoom: 15
        });

        infowindow = new google.maps.InfoWindow({
            maxWidth:200
        });
        
        var marker = new google.maps.Marker({
          map: map,
          position: pyrmont
        });
        
        var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: pyrmont,
          radius: parseInt(Radius),
          type: [Type]
        }, callback);
        
        //Ve hinh tron
        var cityCircle = new google.maps.Circle({
           strokeColor: '#FF0000',
           strokeOpacity: 0.8,
           strokeWeight: 2,
           fillColor: '#FF0000',
           fillOpacity: 0.35,
           map: map,
           center:  pyrmont,
           radius: parseInt(Radius)
        });
      }

      function callback(results, status) {
        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
        }
      }

      function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });
        
        //Service distance
        var from = {lat: 10.770527, lng: 106.684417};
        var fromName = '376 Võ văn tần, phường 3';
        var to = {lat: placeLoc.lat(), lng: placeLoc.lng()};
        var service_distance = new google.maps.DistanceMatrixService;
        var distance;
        var duration;
        var distance_text = '';
        var duration_text = '';
        service_distance.getDistanceMatrix({
            origins: [from, fromName],
            destinations: [placeLoc, place.name],
            travelMode: 'DRIVING'
        }, function(response, status) {
            if(status == 'OK') {
                    var origins = response.originAddresses;
                    var destinations = response.destinationAddresses;
                    for (var i = 0; i < origins.length; i++) {
                        var results = response.rows[i].elements;
                         
                        for (var j = 0; j < results.length; j++) {
                            var element = results[j];
                            
                            distance = element.distance;
                            duration = element.duration;
                           
                            if(distance != undefined) 
                                distance_text = element.distance.text;
                            if(duration != undefined)
                                duration_text = element.duration.text;
                            var from = origins[i];
                            var to = destinations[j];
                            
                        }
                    }
                }
        });
        
        google.maps.event.addListener(marker, 'mouseover', function() {
            infowindow.setContent('<div><strong>'+place.name + '</strong></div>' + '<div>'+place.vicinity+'</div><div><strong>Khoảng cách:</strong> ' + distance_text + '</div>');
            infowindow.open(map, this);
        });
        google.maps.event.addListener(marker, 'mouseout', function() {
            infowindow.close();
        });
      }
      
        
   
    </script>
	