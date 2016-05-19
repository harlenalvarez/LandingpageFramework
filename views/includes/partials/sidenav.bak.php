<?php 
    $options = array(
        "myCompanyView"     => array("My Company","Add company info, change Logo, color schema, etc.","fa-building-o",5),
        "myAccountView"     => array("My Account", "Edit your name, address, email, etc..","fa-user",1),
        "pagesView"         => array("Pages", "Edit each page of yout site and add content","fa-gears",6),
        "imagesView"        => array("Images", "Add / Edit / Manage logos, pictures and icons","fa-picture-o",1),
        "videosView"        => array("Videos","Add / Edit / Manage personal or youtube videos","fa-video-camera",1),
        "slideshowView"     => array("Slideshows","Add / Edit /Manage your page slideshows","fa-picture-o",2),
        "usersView"         => array("Users", "Add / Edit / Manage users to this site", "fa-users",2)
    );
    switch ($params){
        case "userinfo":
            $page   = "#1";
            break;
        case "editpages":
            $page   = "#2";
            break;
        case "images":
            $page   = "#3";
            break;
        case "videos":
            $page   = "#4";
            break;
        case "slideshows":
            $page   = "#5";
            break;
        case "users":
            $page   = "#6";
            break;
        default:
            $page   = "#0";
            break;
    }
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("<?php echo $page; ?>").click();
         
    });
    function hideSideNavViews(){
        $('div.viewsContainer > div').each(function(){
            $(this).hide();
        });
    }
    function removeSideNavActive(){
        $('#sideNav > ul li').each(function(){
            $(this).removeClass('activeLink');
        });
    }
    function showSideNavViews(li,viewId){
        hideSideNavViews();
        removeSideNavActive();
        $(viewId).show();
        if(viewId.id == "imagesView") {
            loadAlbums();
        }
        else if(viewId.id == "videosView"){
            getMediaAlbums("_Videos","video");
        }
        $(li).addClass('activeLink');
        setTimeout(adjustFooter,200);
    }
    
</script>
<nav id="sideNav" class="rounded-sm">
    <ul>
        <?php 
        $first = 0;
        foreach($options as $locationName => $values){ 
            if($_SESSION['user_access_level']<$values[3]){$first++; continue;} ?>
        <li id="<?php echo $first++;?>" data-toggle="tooltip" title="<?php echo $values[1]; ?>"  onclick="showSideNavViews(this,<?php echo $locationName ?>)"><span><i class="fa <?php echo $values[2]?>">&nbsp;&nbsp;&nbsp;&nbsp;</i><?php echo $values[0]; ?></span></li>
        <?php } ?>
    </ul>
</nav>

