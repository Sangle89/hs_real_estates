<style>
#listDistance > label,
#listUtility >label{
    margin-right: 10px;
}
#listDistance > label>input,
#listUtility >label>input{
    float:left;
    margin-right: 5px;
}
</style>
<div style="padding:10px;">
<strong>Khoảng cách:</strong>
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
</div>
    <div id="map" style="width: 100%;height:350px;"></div>
    <div id="tableResult"></div>

<script>
var API_KEY = '<?=API_KEY?>';
var map;
var infowindow;
var _lat = '';
var _lng = '';
var latlng = '';
var ArrContent = [];
function getLatLng() {
	
	geocoder = new google.maps.Geocoder();
    geocoder.geocode({
               'address': '<?=$address?>' 
         }, function(results, status){console.log(status);
                if(status == google.maps.GeocoderStatus.OK) {
                   //latlng.push(results[0].geometry.location.lat());
				   //latlng.push(results[0].geometry.location.lng());
				   
				   return results[0].geometry.location;
				
         }
    });
	return latlng;
}
getLatLng('<?=$address?>');

                                                       $(document).ready(function() {
															
															
															
                                                            $('#listDistance input[type="radio"]').on('change', function() {
                                                                var selected = [];
                                                                $.each($('.utility:checked'), function(a, b) {
                                                                        selected.push($(b).val());
                                                                });
                                                                
                                                                $('#RadiusCurrent').text($('#listDistance input[type="radio"]:checked').val() + 'm');
																//Load ajax
																$('#loadingUtility').show();
																$('#displayUtility').html('');
                                                                /*$.ajax({
                                                                   url: '/api/place.php',
                                                                   type: 'post',
                                                                   dataType: 'html',
                                                                   data: {radius: $('#listDistance input[type="radio"]:checked').val(), 
                                                                        type: selected,
                                                                        lat: latlng[0],
                                                                        lng: latlng[1]
                                                                   },
                                                                   success: function(html) {
                                                                    $('#displayUtility').html(html);
																	$('#loadingUtility').hide();
                                                                   } 
                                                                });*/
                                                                initMap(selected, $('#listDistance input[type="radio"]:checked').val());
                                                                
                                                            });
                                                            
                                                            $('.utility').change(function() {
                                                                var selected = [];
                                                                $.each($('.utility:checked'), function(a, b) {
                                                                    selected.push($(b).val());
                                                                });
                                                                //Load ajax
																$('#loadingUtility').show();
																$('#displayUtility').html('');
                                                                /*$.ajax({
                                                                   url: '/api/place.php',
                                                                   type: 'post',
                                                                   dataType: 'html',
                                                                   data: {radius: $('#listDistance input[type="radio"]:checked').val(), 
                                                                        type: selected,
                                                                        lat: latlng[0],
                                                                        lng: latlng[1]
                                                                   },
                                                                   success: function(html) {
                                                                    $('#displayUtility').html(html);
																	$('#loadingUtility').hide();
                                                                   } 
                                                                });*/
                                                                initMap(selected, $('#listDistance input[type="radio"]:checked').val());
                                                            })
                                                        });

                                                        function initMap(Type, Radius) {
															//var latlng = getLatLng();
                                                            geocoder = new google.maps.Geocoder();
    geocoder.geocode({
               'address': '<?=$address?>' 
         }, function(results, status){console.log(status);
                if(status == google.maps.GeocoderStatus.OK) {
                   _lat = (results[0].geometry.location.lat());
				   _lng = (results[0].geometry.location.lng());
				   
				   var pyrmont = {
                                                                lat: parseFloat(_lat),
                                                                lng: parseFloat(_lng)
                                                            };
                                                            var fromName = '<?=$address?>';
                                                            
                                                            map = new google.maps.Map(document.getElementById('map'), {
                                                                center: pyrmont,
                                                                zoom: 15,
																zoomControl: true,
																  scaleControl: false,
																  scrollwheel: false,
																  disableDoubleClickZoom: true,
                                                            });

                                                            infowindow = new google.maps.InfoWindow({
                                                                maxWidth: 200
                                                            });

                                                            var marker = new google.maps.Marker({
                                                                map: map,
                                                                position: pyrmont
                                                            });

                                                            var service = new google.maps.places.PlacesService(map);
                                                            
                                                            for(i=0; i<Type.length;i++) {
                                                                    service.nearbySearch({
                                                                    location: pyrmont,
                                                                    radius: parseInt(Radius),
                                                                    type: Type[i]
                                                                }, callback);    
                                                            }
                                                            

                                                            //Ve hinh tron
                                                            var cityCircle = new google.maps.Circle({
                                                                strokeColor: '#FF0000',
                                                                strokeOpacity: 0.8,
                                                                strokeWeight: 2,
                                                                fillColor: '#FF0000',
                                                                fillOpacity: 0.35,
                                                                map: map,
                                                                center: pyrmont,
                                                                radius: parseInt(Radius)
                                                            });
				   
			}
        });
														}
														
														var rad = function(x) {
														  return x * Math.PI / 180;
														};
														
														var getDistance = function(p1, p2) {console.log(p1);
														  var R = 6378137; // Earth’s mean radius in meter
														  var dLat = rad(p2.lat() - p1.lat);
														  var dLong = rad(p2.lng() - p1.lng);
														  var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
															Math.cos(rad(p1.lat)) * Math.cos(rad(p2.lat())) *
															Math.sin(dLong / 2) * Math.sin(dLong / 2);
														  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
														  var d = R * c;
														  return d; // returns the distance in meter
														};

                                                        function callback(results, status) {
                                                            var TableOpen = '<div style="max-height:200px;overflow:auto;margin-bottom:20px;border:1px solid #ddd"><table class="table">';
                                                            var TableClose = '</table></div>';
                                                            var Store = [];
                                                            var Restaurant = [];
                                                            var Bank = [];
                                                            var Church = [];
                                                            var ATM = [];
                                                            var Hospital = [];
                                                            var BusStation = [];
                                                            var Loging = [];
                                                            var TableContent = '';
															var LatLng = getLatLng('<?=$address?>');
                                                            
                                                            if (status === google.maps.places.PlacesServiceStatus.OK) {
                                                                for (var i = 0; i < results.length; i++) {
                                                                    createMarker(results[i]);
                                                                    var distance;
																	
                                                                    distance = getDistance(LatLng, results[i].geometry.location);
                                                                    results[i].distance = distance;
                                                                    for(j=0; j<results[i].types.length; j++) {
                                                                        if(results[i].types[j]=="restaurant"){
                                                                            Restaurant.push(results[i]);
                                                                        } 
                                                                        if(results[i].types[j]=="store"){
                                                                            Store.push(results[i]);
                                                                        } 
                                                                        if(results[i].types[j]=="bank"){
                                                                            Bank.push(results[i]);
                                                                        }
                                                                        if(results[i].types[j]=="church"){
                                                                            Church.push(results[i]);
                                                                        } 
                                                                        if(results[i].types[j]=="atm"){
                                                                            ATM.push(results[i]);
                                                                        }
                                                                        if(results[i].types[j]=="hospital"){
                                                                            Hospital.push(results[i]);
                                                                        }
                                                                        if(results[i].types[j]=="bus_station"){
                                                                            BusStation.push(results[i]);
                                                                        }
                                                                        if(results[i].types[j]=="loging"){
                                                                            Loging.push(results[i]);
                                                                        }
                                                                    }
                                                                    
                                                                }
                                                            }
                                                            if(Restaurant!='' && $('input[type="checkbox"][value="restaurant"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Nhà hàng('+Restaurant.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Restaurant.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Restaurant[i].name+'</td><td width="45%">'+Restaurant[i].vicinity+'</td><td width="10%">'+Restaurant[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['restaurant'] = TableContent;
                                                            }
                                                            if(Store!='' && $('input[type="checkbox"][value="store"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Cửa hàng('+Store.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Store.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Store[i].name+'</td><td width="45%">'+Store[i].vicinity+'</td><td>'+Store[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['store'] = TableContent;
                                                            }
                                                            
                                                            if(Bank!='' && $('input[type="checkbox"][value="bank"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Ngân hàng('+Bank.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Bank.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Bank[i].name+'</td><td width="45%">'+Bank[i].vicinity+'</td><td>'+Bank[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['bank'] = TableContent;
                                                            }
                                                            if(Church!='' && $('input[type="checkbox"][value="church"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Nhà thờ('+Church.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Church.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Church[i].name+'</td><td width="45%">'+Church[i].vicinity+'</td><td>'+Church[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['church'] = TableContent;
                                                            }
                                                            if(ATM!='' && $('input[type="checkbox"][value="atm"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">ATM('+ATM.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<ATM.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+ATM[i].name+'</td><td width="45%">'+ATM[i].vicinity+'</td><td>'+ATM[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['atm'] = TableContent;
                                                            }
                                                            if(Hospital!='' && $('input[type="checkbox"][value="hospital"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Bệnh viện('+Hospital.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Hospital.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Hospital[i].name+'</td><td width="45%">'+Hospital[i].vicinity+'</td><td>'+Hospital[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['hospital'] = TableContent;
                                                            }
                                                            if(BusStation!='' && $('input[type="checkbox"][value="bus_station"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Trạm xe('+BusStation.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<BusStation.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+BusStation[i].name+'</td><td width="45%">'+BusStation[i].vicinity+'</td><td>'+BusStation[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['bus_station'] = TableContent;
                                                            }
                                                            if(Loging!='' && $('input[type="checkbox"][value="loging"]').prop('checked')) {
                                                                TableContent = '<table class="table no-border" style="margin:0"><tr><th width="45%">Khách sạn, nhà nghỉ('+Loging.length+')</th><th width="45%">Địa chỉ</th><th width="10%">Khoảng cách</th></tr></table>';
                                                                TableContent += TableOpen;
                                                                for(i=0; i<Loging.length;i++) {
                                                                    TableContent +='<tr><td width="45%">'+Loging[i].name+'</td><td width="45%">'+Loging[i].vicinity+'</td><td>'+Loging[i].distance+'</td></tr>';
                                                                }
                                                                TableContent += TableClose;
                                                                ArrContent['loging'] = TableContent;
                                                            }
                                                            
                                                            var append_html = '';
                                                            if($('input[type="checkbox"][value="restaurant"]').prop('checked') && ArrContent['restaurant']!='undefined') {
                                                                append_html = ArrContent['restaurant'];
                                                            }
                                                            if($('input[type="checkbox"][value="store"]').prop('checked') && ArrContent['store']!='undefined') {
                                                                append_html += ArrContent['store'];
                                                            }
                                                            if($('input[type="checkbox"][value="bank"]').prop('checked') && ArrContent['bank']!='undefined') {
                                                                append_html += ArrContent['bank'];
                                                            }
                                                            if($('input[type="checkbox"][value="church"]').prop('checked') && ArrContent['church']!='undefined') {
                                                                append_html += ArrContent['church'];
                                                            }
                                                            if($('input[type="checkbox"][value="atm"]').prop('checked') && ArrContent['atm']!='undefined') {
                                                                append_html += ArrContent['atm'];
                                                            }
                                                            if($('input[type="checkbox"][value="hospital"]').prop('checked') && ArrContent['hospital']!='undefined') {
                                                                append_html += ArrContent['hospital'];
                                                            }
                                                            if($('input[type="checkbox"][value="bus_station"]').prop('checked') && ArrContent['bus_station']!='undefined') {
                                                                append_html += ArrContent['bus_station'];
                                                            }
                                                            if($('input[type="checkbox"][value="loging"]').prop('checked') && ArrContent['loging']!='undefined') {
                                                                append_html += ArrContent['loging'];
                                                            }
                                                            $('#displayUtility').html(append_html);
                                                            $('#loadingUtility').hide();
                                                        }

                                                        function createMarker(place) {
                                                            var placeLoc = place.geometry.location;
                                                            var marker = new google.maps.Marker({
                                                                map: map,
																//icon: '<?=base_url('theme/images/places/icon-bus.png')?>',
                                                                position: place.geometry.location
                                                            });

                                                            //Service distance
                                                            var LatLng = getLatLng('<?=$address?>');
                                                            var fromName = '<?=$address?>';
                                                            var distance = '';
                                                            
                                                            distance = getDistance(LatLng, placeLoc);
                                                            google.maps.event.addListener(marker, 'mouseover', function() {
                                                                infowindow.setContent('<div><strong>' + place.name + '</strong></div>' + '<div>' + place.vicinity + '</div><div><strong>Khoảng cách:</strong> ' + distance + '</div>');
                                                                infowindow.open(map, this);
                                                                
                                                            });
                                                            google.maps.event.addListener(marker, 'mouseout', function() {
                                                                infowindow.close();
                                                            });
                                                            
                                                            return distance;
                                                        }
var _default = ['store'];
                                                        initMap(_default, 1000);
</script>