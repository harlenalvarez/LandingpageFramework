<?php
class ProgramModules{

    public static function getTableModule($headings)
    {
        if($headings[0] == "Completed Orders")
        {
            $bg = "background-color:#47AA42";
            
        }
        elseif($headings[0] == "Incomplete Orders" )
        {
            $bg = "background-color:#EA7F1E";
        }
        elseif($headings[0] == "Canceled Orders")
        {
            $bg = "background-color:#EE2E24";
        }
        $multipleHeadings = false;
        $msg = "<div><table class = 'table table-bordered'><thead style=$bg;color:white; ><tr>";
        if(count($headings) > 1)
        {
            $multipleHeadings = true;
        }
        foreach($headings as $num => $heading)
        {
            if($multipleHeadings && $num == 0 )
            {
                $msg .= "<th colspan=2>$heading</th></tr><tr>";
            }
            elseif($multipleHeadings)
            {
                $msg.= "<th>$heading</th>";
            }
            
        }
        $msg .= "</tr></thead><tbody></tbody></table></div>";
        return $msg;
         
    }

    public static function dropDownMenu($id,$name, $values = array(), $form='',$selected='')
    {
        if(empty($values)||  is_null($values)||count($values)<1){
            return "";
        }
        $msg = "<select class='form-control' id='$id' form='$form' name='$name' onload=setIndex()>";
        $msg .= "<option value=empty>--</option>";
        foreach($values as $value)
        {
            if($value == $selected )
            {
                $msg.="<option value='$value' selected=selected>$value</option>";
            }
            else 
            {
                $msg.="<option value='$value'>$value</option>";
            }
            
        }
        $msg .= "</select>";
        
        return $msg;
                                   
    }
    
    public static function dropDownMenuWithKeyValue($id,$name, $values = array(), $form='',$selected=''){
        if(empty($values)||  is_null($values)||count($values)<1){
            return "";
        }
        
        $msg = "<select class='form-control' id='$id' form='$form' name='$name' onload=setIndex()>";
        $msg .= "<option value=empty>--</option>";
        foreach($values as $id => $value)
        {
            if($value == $selected || $id == $selected)
            {
                $msg.="<option value='$id' selected=selected>$value</option>";
            }
            else 
            {
                $msg.="<option value='$id'>$value</option>";
            }
            
        }
        $msg .= "</select>";
        
        return $msg;
    }
    
    public static function fakeNav(){
        $msg  ="<style title='fakeNavStyle' type='text/css'>"
                . "#fakeNav{background-color:#000;color:white;} "
                . "#fakeNav li{display:inline-block; padding: 0 10px; cursor:pointer;text-decoration:none; } "
                . "#fakeNav ul{padding:0;margin:0;} "
                . "#fakeNav li:hover{background-color:black;color:white;}"
                . "</style>";
        $msg .= "<nav id='fakeNav'><ul><li onclick='showPageEditOptions(fakeNavView)'>Click Me To Edit</li><li onclick='javascript:toggleActive(this)'>Example 2</li></ul></nav>";
        return $msg;
    }
    
    public static function googleMaps($divId,$address){
        ?>

            <script type="text/javascript">
                  function initialize() {
                    var geocoder    = new google.maps.Geocoder();
                    geocoder.geocode({ 'address': "<?php echo $address ?>" }, function (results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                                var mapOptions = {
                                                    center: results[0].geometry.location,
                                                    zoom: 12,
                                                    scrollwheel: false,
                                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                                };
                                                var map     = new google.maps.Map(document.getElementById('<?php echo $divId?>'), mapOptions);
                                                //map.setCenter(results[0].geometry.location);

                                                var geoPlaceId  = results[0].place_id;
                                                var infowindow  = new google.maps.InfoWindow();
                                                var service     = new google.maps.places.PlacesService(map);
                                                var request     = {placeId:geoPlaceId};
                                                service.getDetails(request, function(place, status) {
                                                  if (status == google.maps.places.PlacesServiceStatus.OK) {
                                                   
                                                    var marker  = new google.maps.Marker({
                                                        map: map,
                                                        position: place.geometry.location
                                                    });
                                                    google.maps.event.addListener(marker, 'click', function() {
                                                      infowindow.setContent(place.name);
                                                      infowindow.open(map, this);
                                                    });
                                                  }
                                                  else
                                                  {
                                                      console.log("Error with places");
                                                  }
                                                });
                                        } 
                                        else{
                                            alert("Problem with geolocation");
                                        } 
                                    });
                    
                    
                    
                  }
                  google.maps.event.addDomListener(window, 'load', initialize);
            </script>
            <div id="<?php echo $divId?>" class="mapCanvas rounded-md"></div>
            
        <?php
    }
    
    public static function googleStreetView($divId,$address){
        ?>
        
        <script type="text/javascript">
        function initializeStreetView(){
            var geocoder    = new google.maps.Geocoder();
            geocoder.geocode({ 'address': "<?php echo $address?>" }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var centerMap       = results[0].geometry.location;
                    var streetLoc       = new google.maps.LatLng(centerMap.A,centerMap.F);
                    var streetSer       = new google.maps.StreetViewService();
                    streetSer.getPanoramaByLocation(streetLoc,100, function(data, status){
                        if(status == google.maps.StreetViewStatus.OK){
                            var nearLoc = data.location.latLng;
                            var panoramaOptions = {
                                            position: nearLoc,
                                            pov: {
                                              heading: 165,
                                              pitch: 0
                                            },
                                            zoom: 1
                                          };

                            var panorama = new  google.maps.StreetViewPanorama(document.getElementById("<?php echo $divId?>"), panoramaOptions);
                            panorama.setVisible(true);
                        }
                        else{
                            $("#<?php echo $divId?>").hide();
                           
                        }
                    });
                    
                }

            });
        }
        
        google.maps.event.addDomListener(window, 'load', initializeStreetView);
        </script>
        <div id="<?php echo $divId?>" class="panoramicStreetView"></div>
    <?php
    
    }

    public static function slideShow($params){
        $hasYouTube   = false;
        $autoplay = (isset($params['autoplay']))?$params['autoplay']:"true";
        $size = (isset($params['size']))?$params['size']:"big";
        $interval = (isset($params['interval']))?$params['interval']:3000;
        $wrap = (isset($params['wrap']))?$params['wrap']:"true";
        $pauseOnHover = (isset($params['pauseOnHover']))?$params['pauseOnHover']:"true";
        $rows = (isset($params['rows']))?$params['rows']:1;
        $slidesPerRow = (isset($params['slidesPerRow']))?$params['slidesPerRow']:1;
        $specialClass = (isset($params['specialClass']))?$params['specialClass']:"";
        $vertical = (isset($params['vertical']))?$params['vertical']:"false";
        $fade = (isset($params['fade']))?$params['fade']:"false";
        $arrows = (isset($params['arrows']))?$params['arrows']:"false";
        $dots = (isset($params['dots']))?$params['dots']:"false";
        $speed = (isset($params['speed']))?$params['speed']:500;
        $html = "<div class='slidesWrapper'>";
        if($size == "big")
        {
            $html .= "<div id='{$params['slideshow_name']}' class='dwSlide'>";
            #$html .= (isset($params))'

        }
        else
        {
            $html .= "<div id='{$params['slideshow_name']}' class='dwSmallSlide $specialClass'>";
        }
        foreach($params['slides'] as $x => $value){

                $imgSrc     = URL_IMAGES_PATH.$value['path'];

                $html       .= "<div style='position:relative'>";
                if($value['button']){
                    if($size=="big"){
                        $html .= "<img src='{$imgSrc}' alt='{$value['alt']}'/>";
                        $html .= $value['button_html'];
                        $html .= $value['caption'];
                    }
                    else{
                        $html   .= "<a href='{$value['button_url']}'>"
                            . "<img src='$imgSrc' alt='{$value['alt']}' >";
                        if($value['caption']!= ""){
                            $html.="<h5>{$value['caption']}</h5>";
                        }
                        $html   .= "</a>";
                    }


                }
                else{
                    $html   .= "<img src='$imgSrc' alt='{$value['media_alt']}'>";
                    if($value['caption']!= "" && $size !== "big"){
                        $html.="<h5>{$value['slideshow_caption']}</h5>";
                    }
                    elseif(isset($value['caption'])){
                        $html .= $value['caption'];
                    }
                }
                $html       .= "</div>";
                unset($imgSrc);
        }
        $html           .= "</div>";
        $html           .= $params['slides_caption'];
        $html           .= $params['slides_button'];
        $html           .= "</div>"
                        .  "<script type='text/javascript'>"
                        .  "$('#{$params['slideshow_name']}').slick({"
                                    . "autoplay:{$autoplay},"
                                    . "infinite:{$wrap},"
                                    . "autoplaySpeed:{$interval},"
                                    . "rows:{$rows},"
                                    . "slidesPerRow:{$slidesPerRow},"
                                    . "slidesToShow:{$slidesPerRow},"
                                    . "slidesToScroll:1,"
                                    . "pauseOnHover:{$pauseOnHover},"
                                    . "swipeToSlide:false,"
                                    . "arrows:{$arrows},"
                                    . "vertical:{$vertical},"
                                    . "fade:{$fade},"
                                    . "speed:{$speed},"
                                    . "dots:{$dots}"
                            . "});"
                            .  "</script>";

        
        return $html;
    }

    public static function toCurrency($amount, $currencySymbol = "$"){
        $result = $amount;
        if(is_numeric($amount)){

            $amount = round($amount,2);
            //$amount = preg_replace("/\d(?=(\d{3})+\.)/","",$amount);
            $format = "$currencySymbol%01.2Lf\n";

            $result = sprintf($format,$amount);
        }
        return $result;
    }

}
