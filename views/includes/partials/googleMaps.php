
<?php
    function loadMap($divId){
?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?se"></script>
<script type="text/javascript">
      function initialize() {
        var mapOptions = {
          center: { lat: -34.397, lng: 150.644},
          zoom: 8
        };
        var map = new google.maps.Map(document.getElementById('map-canvas'),
            mapOptions);
      }
      google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div id="map-canvas"></div>
    <?php } 
