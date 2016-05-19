<?php
/**
 * User: halvarez
 * Date: 5/19/2015
 * Time: 5:36 PM
 * Helper function to create a media table without needing multiple files
 * The edit wrappers have been removed as well from this function.
 * Call this function using the partialRender and pass this file name along with a string identifier
 *
 * The String has to be as fallow
 * string identifier    = "_uniqueName";
 * example
 * string identifier    = "_images";
 * string identifier    = "_slideshows";
 *
 * Second string needede is one to specify the media type. if none is passed then all types of media will be shown
 * string mediaType     = "video"
 * string mediaType     = "image"
 * string mediaType     = "audio"
 *
 */

//Creating a set of values for eachId;
$mediaType              = (isset($params['mediaType']))?$params['mediaType']:"";
$identifier             = (isset($params['identifier']))?$params['identifier']:"";

$boostrapId = array(
    "lightboxErrorDiv"              => "lightboxErrorDiv".$identifier,
    "albumsDiv"                     => "albumsDiv".$identifier,
    "imageGalleryWrapper"           => "imageGalleryWrapper".$identifier,
    "blueimp-gallery"                => "blueimp-gallery".$identifier,
    "hiddenAlbumId"                 => "hiddenAlbumId".$identifier,
    "hiddenPageNumber"              => "hiddenPageNumber".$identifier,
    "imagesControlsWrapper"         => "imageControlsWrapper".$identifier,
    "topControls"                   => "topControls".$identifier,
    "imageSortOption"               => "imageSortOption".$identifier,
    "imageSearchBootStrap"          => "imageSearchBootstrap".$identifier,
    "image-search-addon"            => "image-search-addon".$identifier,
    "links"                         => "links".$identifier,
    "bottomControls"                => "bottomControls".$identifier,
    "showingMessage"                => "showingMessage".$identifier,
    "imageLimitOption"              => "imageLimitOption".$identifier,
    "imagePaginationDetails"        => "imagePaginationDetails".$identifier

);

?>


<div id='<?php echo $boostrapId["lightboxErrorDiv"]; ?>'></div>
<div id='<?php echo $boostrapId["albumsDiv"]; ?>'></div>
<!--
Thew other portion is within the head seaction
-->
<!---This is for images and videos purposes -->
<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id ='<?php echo $boostrapId["imageGalleryWrapper"]; ?>' class="hideElement" >
    <div id='<?php echo $boostrapId["blueimp-gallery"]; ?>' class="blueimp-gallery blueimp-gallery-controls">
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
    <input type="hidden" id='<?php echo $boostrapId["hiddenAlbumId"]; ?>' value="0"/>
    <input type="hidden" id='<?php echo $boostrapId["hiddenPageNumber"];?>' value="0"/>
    <div id='<?php echo $boostrapId["imagesControlsWrapper"];?>'>
        <div id='<?php echo $boostrapId["topControls"]; ?>'>
            <select id='<?php echo $boostrapId["imageSortOption"]?>' class='form-control sm-md-form side' onchange="loadMediaWithoutAlbum('<?php echo $identifier."','".$mediaType; ?>')">
                <option value="date_desc">Date | Newest First</option>
                <option value="date_asc">Date | Oldest First</option>
                <option value="name_asc">Name | A-Z</option>
                <option value="name_desc">Name | Z-A</option>
                <option value="size_desc">Size | Largest First</option>
                <option value="size_asc">Size | Smallest First</option>
            </select>
            <div class="float-right">
                <div class="input-group sm-md-form">
                    <input type="search" class="form-control" placeholder="Search by name" required="true" aria-describedby="image-search-addon" name="imageSearch" id='<?php echo $boostrapId["imageSearchBootStrap"];?>'>
                    <span class="input-group-btn" id="image-search-addon">
                        <button onclick="loadImagesWithoutAlbum('<?php echo $identifier."','".$mediaType; ?>')" class='btn btn-dark-default'>
                            <span class='glyphicon glyphicon-search'></span>
                        </button>
                    </span>
                </div>
            </div>
            <div class="clearFloatDiv"></div>
        </div>
        <div id='<?php echo $boostrapId["links"]; ?>'></div>
        <div class="clearFloatDiv"></div>
        <div id='<?php echo $boostrapId["bottomControls"]; ?>'>
            <div class="side"  style="white-space: nowrap;">
                <span id='<?php echo $boostrapId["showingMessage"]; ?>'></span>
                <select id='<?php echo $boostrapId["imageLimitOption"]; ?>' class="form-control ex-sm-form side" onchange="loadImagesWithoutAlbum('<?php echo $identifier."','".$mediaType; ?>')">
                    <option value="10">10</option>
                    <option selected="selected" value="25">25</option>
                    <option value="50">50</option>
                    <option value="75">75</option>
                    <option value="100">100</option>
                </select>
                &nbsp; Media per page.
            </div>
            <div class="side float-right">
                <nav id='<?php echo $boostrapId["imagePaginationDetails"]; ?>'>
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