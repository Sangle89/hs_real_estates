<!DOCTYPE html>
<html>
  <head>
    <title>Place searches</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 500px;
        width:100%;
      }
      .container{
        width:1000px;
        margin: 0 auto;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
    
  </head>
  <body>
    
    <div class="container">
    <button id="loadMap">Load map</button>
    <div id="showMap"></div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?=API_KEY?>&libraries=places"></script>
    <script src="<?=base_url('theme/js/jquery-2.1.4.js')?>"></script>
    <script>
    $(document).ready(function() {
        $('#loadMap').on('click', function() {
            $.ajax({
                url: '<?=base_url('utility/loadmap')?>',
                dataType: 'html',
                type: 'GET',
                success: function(html) {
                    $('#showMap').html(html);
                }
            })
        })
    })
    </script>
  </body>
</html>