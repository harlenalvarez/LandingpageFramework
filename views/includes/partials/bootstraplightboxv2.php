<script type="text/javascript">
    
    function loadAlbums2(){
        $("#albumsDiv2").html("<i class='fa fa-circle-o-notch fa-spin fa-5x'></i>");
        $("#albumsDiv2").showElement();
        $.ajax({
                type:"get",
                url:"<?php echo URL_PATH?>model_control/getAlbums/2",
                success: function(data){
                    $("#albumsDiv2").html(data);
                    adjustFooter();
                },
                error: function(data){
                    $("#albumsDiv2").html(data);
                    adjustFooter();
                }
            });
    }
    function loadImagesWithoutAlbum2(){
        var albumId         = $("#selectedAlbumId2").val();
        loadImagesByAlbum2(albumId,0);
        setTimeout(adjustFooter,500);
    }
    function loadImagesByAlbum2(albumId,page,albumClick){
        if( $("#albumnumber2_"+albumId).children("span").hasClass("glyphicon-folder-close") || albumClick !== true){
            $("#editImageWrapper2").hideElement();
            $("#selectedAlbumId2").val(albumId);
            $("#hiddenPageNumber2").val(page);
            $("#albumsDiv2 > div").each(function(){
                if($(this).children("span").hasClass("glyphicon-folder-open")){
                    $(this).children("span").removeClass("glyphicon-folder-open");
                    $(this).children("span").addClass("glyphicon-folder-close");
                }
            });
            $("#albumnumber2_"+albumId).children("span").removeClass("glyphicon-folder-close");
            $("#albumnumber2_"+albumId).children("span").addClass("glyphicon-folder-open");
            $("#links2").html("<i class='fa fa-circle-o-notch fa-spin fa-5x'></i>");
            var orderByAndType  = $("#imageSortOption2").val();
            var limit           = $("#imageLimitOption2").val();
            var offset          = page*limit;
            $.ajax({
                    type:"post",
                    url:"<?php echo URL_PATH?>model_control/getImagesByAlbum/2",
                    data:{"albumId":albumId,"orderByAndType":orderByAndType,"limit":limit,"offset":offset},
                    success: function(data){
                        var pageData    = JSON.parse(data);
                        
                        $("#showingMessage2").text(pageData.showingMessage);
                        $("#links2").html(pageData.imagesLink);
                        $("#imagePaginationDetails2").html(pageData.pagination);
                        adjustFooter();
                    },
                    error: function(data){$("#links2").html(data);adjustFooter();}
            });
            $("#imageGalleryWrapper2").showElement();
        }
        else{
            $("#editImageWrapper2").hide();
            $("#albumnumber2_"+albumId).children("span").removeClass("glyphicon-folder-open");
            $("#albumnumber2_"+albumId).children("span").addClass("glyphicon-folder-close");
            $("#imageGalleryWrapper2").hideElement();
            
        }
    }
   
</script>
<div id="lightboxErrorDiv2"></div>
<div id="albumsDiv2"></div>
<!--
Thew other portion is within the head seaction
-->
<!---This is for images and videos purposes -->
<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id = "imageGalleryWrapper2" class="hideElement" >
    <div id="blueimp-gallery2" class="blueimp-gallery blueimp-gallery-controls">
        <!-- The container for the modal slides -->
        <div class="slides"></div>
        <!-- Controls for the borderless lightbox -->
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
    <input type="hidden" id="hiddenAlbumId2" value="0"/>
    <input type="hidden" id="hiddenPageNumber2"    value="0"/>
    <div id="imagesControlsWrapper2">
        <div id="topControls2">
            <select id="imageSortOption2" class='form-control sm-md-form side' onchange="loadImagesWithoutAlbum2()">
                <option value="date_desc">Date | Newest First</option>
                <option value="date_asc">Date | Oldest First</option>
                <option value="name_asc">Name | A-Z</option>
                <option value="name_desc">Name | Z-A</option>
                <option value="size_desc">Size | Largest First</option>
                <option value="size_asc">Size | Smallest First</option>
            </select>
            <div class="float-right">
                <div class="input-group sm-md-form">
                    <input type="search" class="form-control" placeholder="Search by name" required="true" aria-describedby="image-search-addon" name="imageSearch">
                    <span class="input-group-btn" id="image-search-addon2">
                        <button onclick="loadImagesWithoutAlbum2()" class='btn btn-dark-default' name='addAlbumButton'>
                            <span class='glyphicon glyphicon-search'></span>
                        </button>
                    </span>
                </div> 
            </div>

        </div>
        <div id="links2"></div><div class="clearFloatDiv"></div>
        <div id="bottomControls2">
            <div class="side"  style="white-space: nowrap;">
            <span id="showingMessage2"></span>
            <select id="imageLimitOption2" class="form-control ex-sm-form side" onchange="loadImagesWithoutAlbum2()">
                <option value="10">10</option>
                <option selected="selected" value="25">25</option>
                <option value="50">50</option>
                <option value="75">75</option>
                <option value="100">100</option>
            </select>
            &nbsp; Images per page.
            </div>
            <div class="side float-right">
            <nav id="imagePaginationDetails2">
                <ul class="pagination">
                  <li class="disabled">
                      <a href="#" aria-label="First">
                          <span aria-hidden="true">&laquo;</span>
                      </a>
                  </li>
                  <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                    <li>
                        <a href="#" aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
             </nav>
            </div>
        </div>
    </div>
    
</div>

<script type="text/javascript" src="<?php echo URL_JS_PATH ?>jquery.blueimp-gallery.min.js"></script>