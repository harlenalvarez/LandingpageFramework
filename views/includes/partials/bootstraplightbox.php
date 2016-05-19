<script type="text/javascript">
    
    function loadAlbums(){
        $("#albumsDiv").html("<i class='fa fa-circle-o-notch fa-spin fa-5x'></i>");
        $("#albumsDiv").show();
        $.ajax({
                type:"get",
                url:"<?php echo URL_PATH?>model_control/getAlbums",
                success: function(data){
                    $("#albumsDiv").html(data);
                    adjustFooter();
                },
                error: function(data){
                    $("#albumsDiv").html(data);
                    adjustFooter();
                }
            });
    }
    function loadAlbumsList(selectedId){
        $.ajax({
            type:"get",
            url:"<?php echo URL_PATH?>model_control/getAlbumsNotByImage",
            data:"imageId="+selectedId,
            success: function(data){
                $("#editImageAlbumAdd").html(data);
                adjustFooter();
            }
        });
    }
    function loadImageAlbumsList(selectedId){
        $.ajax({
                type:"get",
                url:"<?php echo URL_PATH?>model_control/getImageAlbumsList",
                data:"imageId="+selectedId,
                success: function(data){
                    $("#editImageAlbumRemove").html(data);
                    adjustFooter();
                }
        });
    }
    function loadImagesWithoutAlbum(){
        var albumId         = $("#selectedAlbumId").val();
        
        loadImagesByAlbum(albumId,0);
        setTimeout(adjustFooter,500);
    }
    function editImage(imageId){
        $("#imageGalleryWrapper").hide();
        $("#editImageWrapper").show();
        $.ajax({
            type:"post",
            url:"<?php echo URL_PATH?>model_control/getImage",
            data:{"imageId":imageId},
            success: function(data){
                var img     = JSON.parse(data);
                var imgPath;
                if(img.image_special_view_path != ""){
                    imgPath = img.media_special_view_path;
                }
                else
                {
                    imgPath = img.media_path;
                }
                <?php if(isset($_SESSION['user_access_level'])&&$_SESSION['user_access_level']>1){ ?>
                $("#editImageAlt").val(img.media_alt);
                <?php } ?>
                $("#editHiddenImage").val(img.media_id);
                $("#editHiddenImageUser").val(img.user_id);
                $("#editImageCaption").val(img.media_caption);
                $("#editImageView").attr("src",imgPath);
                loadAlbumsList(img.media_id);
                loadImageAlbumsList(img.media_id);
                adjustFooter();
            }
        })
        
    }
    function loadImagesByAlbum(albumId,page,albumClick){
        if( $("#albumnumber_"+albumId).children("span").hasClass("glyphicon-folder-close") || albumClick !== true){
            $("#editImageWrapper").hide();
            $("#selectedAlbumId").val(albumId);
            $("#hiddenPageNumber").val(page);
            $("#albumsDiv > div").each(function(){
                if($(this).children("span").hasClass("glyphicon-folder-open")){
                    $(this).children("span").removeClass("glyphicon-folder-open");
                    $(this).children("span").addClass("glyphicon-folder-close");
                }
            });
            $("#albumnumber_"+albumId).children("span").removeClass("glyphicon-folder-close");
            $("#albumnumber_"+albumId).children("span").addClass("glyphicon-folder-open");
            $("#links").html("<i class='fa fa-circle-o-notch fa-spin fa-5x'></i>");
            var orderByAndType  = $("#imageSortOption").val();
            var limit           = $("#imageLimitOption").val();
            var offset          = page*limit;
            var searchText      = $("#imageSearchBootStrap").val();
            $.ajax({
                    type:"post",
                    url:"<?php echo URL_PATH?>model_control/getImagesByAlbum",
                    data:{"albumId":albumId,"search":searchText,"orderByAndType":orderByAndType,"limit":limit,"offset":offset},
                    success: function(data){
                        var pageData    = JSON.parse(data);
                        
                        $("#showingMessage").text(pageData.showingMessage);
                        $("#links").html(pageData.imagesLink);
                        $("#imagePaginationDetails").html(pageData.pagination);
                        adjustFooter();
                    },
                    error: function(data){$("#links").html(data);adjustFooter();}
            });
            $("#imageGalleryWrapper").show();
        }
        else{
            $("#editImageWrapper").hide();
            $("#albumnumber_"+albumId).children("span").removeClass("glyphicon-folder-open");
            $("#albumnumber_"+albumId).children("span").addClass("glyphicon-folder-close");
            $("#imageGalleryWrapper").hide();
            
        }
    }
    function editSaveImageDetails(){
        var imageId         = $("#editHiddenImage").val();
        var userId          = $("#editHiddenImageUser").val();
        <?php if(isset($_SESSION['user_access_level'])&&$_SESSION['user_access_level']>1){ ?>
        var imageAlt        = $("#editImageAlt").val();
        <?php } ?>
        var imageCaption    = $("#editImageCaption").val();
        $.ajax({
            type:"post",
            url:"<?php echo URL_PATH?>model_control/updateImage",
            <?php if(isset($_SESSION['user_access_level'])&&$_SESSION['user_access_level']>1){ ?>
            data:{"imageAlt":imageAlt,"imageCaption":imageCaption,"imageId":imageId,"userId":userId},
            <?php }else{ ?>
            data:{"imageCaption":imageCaption,"imageId":imageId,"userId":userId},
            <?php } ?>
            success: function(data){$("#editImageStatusMsg").html(data); adjustFooter();},
            error: function(data){$("#editImageStatusMsg").html(data); adjustFooter();}
        });
    }
    function editAddToAlbums(){
        var imageId         = $("#editHiddenImage").val();
        var selectedAlbums  = [];
        $("#editImageAlbumAdd>div input:checked").each(function(){
            selectedAlbums.push($(this).val());
        });
        var sA  = selectedAlbums.join(",");
        $.ajax({
            type:"post",
            url:"<?php echo URL_PATH?>model_control/updateImage",
            data:{"imageId":imageId,"albums":sA},
            success: function(data){$("#editImageStatusMsg").html(data);},
            error: function(data){$("#editImageStatusMsg").html(data);}
        });
    }
    
</script>
<div id="lightboxErrorDiv"></div>
<div id="albumsDiv"></div>
<!--
Thew other portion is within the head seaction
-->
<!---This is for images and videos purposes -->
<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id = "imageGalleryWrapper" class="hideElement" >
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
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
    <input type="hidden" id="hiddenAlbumId" value="0"/>
    <input type="hidden" id="hiddenPageNumber"    value="0"/>
    <div id="imagesControlsWrapper">
        <div id="topControls">
            <select id="imageSortOption" class='form-control sm-md-form side' onchange="loadImagesWithoutAlbum()">
                <option value="date_desc">Date | Newest First</option>
                <option value="date_asc">Date | Oldest First</option>
                <option value="name_asc">Name | A-Z</option>
                <option value="name_desc">Name | Z-A</option>
                <option value="size_desc">Size | Largest First</option>
                <option value="size_asc">Size | Smallest First</option>
            </select>
            <div class="float-right">
                <div class="input-group sm-md-form">
                    <input type="search" class="form-control" placeholder="Search by name" required="true" aria-describedby="image-search-addon" name="imageSearch" id='imageSearchBootStrap'>
                    <span class="input-group-btn" id="image-search-addon">
                        <button onclick="loadImagesWithoutAlbum()" class='btn btn-dark-default'>
                            <span class='glyphicon glyphicon-search'></span>
                        </button>
                    </span>
                </div> 
            </div>

        </div>
        <div id="links"></div><div class="clearFloatDiv"></div>
        <div id="bottomControls">
            <div class="side"  style="white-space: nowrap;">
            <span id="showingMessage"></span>
            <select id="imageLimitOption" class="form-control ex-sm-form side" onchange="loadImagesWithoutAlbum()">
                <option value="10">10</option>
                <option selected="selected" value="25">25</option>
                <option value="50">50</option>
                <option value="75">75</option>
                <option value="100">100</option>
            </select>
            &nbsp; Images per page.
            </div>
            <div class="side float-right">
            <nav id="imagePaginationDetails">
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
<div id="editImageWrapper" class="hideElement">
        <a href="">Go Back</a>
        <br/>
        <img src="" class="imageEditTag" id="editImageView">
        <div>
            <fieldset>
                <legend>Image Details</legend>
                <div id="editImageStatusMsg"></div>
                <input type="hidden" id="editHiddenImage" value=""/>
                <input type="hidden" id="editHiddenImageUser" value=""/>
                <?php if (isset($_SESSION['user_access_level']) && $_SESSION['user_access_level'] > 1)
                {
                    ?>
                    <label for="editImageAlt">Image Alt</label>
                    <input type="input" class="form-control md-form" id="editImageAlt" name="editImageAlt" value="" />
                <?php } ?>
                <br/>
                <label for="editImageCaption">Caption</label>
                <textarea class="form-control md-form" id="editImageCaption" name="editImageCaption"></textarea>
                <button class="btn btn-red" onclick="editSaveImageDetails()"><i id="editSaveIcon" class="fa fa-save">&nbsp;</i>Save</button>
                <br/>

                <div class="side sm-md-form">
                    <label>Add to Album</label>
                    <div id="editImageAlbumAdd" class="multiSelectDiv">
                    </div>
                    <button class="btn btn-red" ><i id="editAddToAlbumIcon" class="fa fa-plus">&nbsp;</i>Add To album</button>
                </div>

                <div class="side sm-md-form">
                    <label>Remove From Albums</label>
                    <div id="editImageAlbumRemove" class="multiSelectDiv">
                    </div>
                    <button class="btn btn-red"><i id="editRemoveFromAlbumIcon" class="fa fa-minus">&nbsp;</i>Remove from album</button>
                </div>
            </fieldset>
        </div>
</div>
<script type="text/javascript" src="<?php echo URL_JS_PATH ?>jquery.blueimp-gallery.min.js"></script>