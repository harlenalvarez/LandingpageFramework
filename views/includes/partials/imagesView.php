<script type="text/javascript">
    function loadAlbums(){
        $.ajax({
                type:"post",
                url:"<?php echo URL_PATH?>model_control/getAlbums",
                data: {"users":temp}, //Change depending on type
                beforeSend: function(){
                    $("#albumnsDiv").html("<h1 class='fa fa-circle-o-notch fa-pulse'></h1>");
                    $("#albumnsDiv").show();
                },
                success: function(data){
                    $("#albumsDiv").html(data);
                    adjustFooter();
                },
                error: function(data){
                    $("#returnMsg").html(data);
                    adjustFooter();
                }
            });
    }
    function loadImages(albumId){
        $.ajax({
                type:"post",
                url:"<?php echo URL_PATH?>model_control/getImages"
        });
    }
</script>
<div id="albumsDiv" class="hideElement"></div>
<div id="imgDiv" class="hideElement">
    
    <?php $this->partialRender()?>
</div>