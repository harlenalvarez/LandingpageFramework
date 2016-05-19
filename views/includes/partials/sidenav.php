<?php 
    $options = array(
        "companyView"     => array("My Company","Add company info, change Logo, color schema, etc.","fa-building-o",5),
        "accountView"     => array("My Account", "Edit your name, address, email, etc..","fa-user",1),
        "pagesView"         => array("Pages", "Edit each page of yout site and add content","fa-gears",6),
        "mediaView"        => array("Media", "Add / Edit / Manage logos, pictures and icons","fa-picture-o",1),
        "videosView"        => array("Videos","Add / Edit / Manage personal or youtube videos","fa-video-camera",1),
        "slideshowView"     => array("Slideshows","Add / Edit /Manage your page slideshows","fa-picture-o",2),
        "usersView"         => array("Users", "Add / Edit / Manage users to this site", "fa-users",2)
    );
    $params = (empty($params)|| is_null($params))?"companyView":$params;
?>
<script type="text/javascript">

   
     function setUrl(viewId){
        if(typeof(history.pushState)!= "undefined"){
            
             var page       = viewId;
             var currentUrl = window.location.href;
             currentUrl     = extractUrl(currentUrl);
             var object     = {Page:page,Url:currentUrl+"/"+page};
             history.pushState(object,object.Page,object.Url);
        }
    }
    rootApp.service("sideNav",function(){
        return{};
    });
    rootApp.controller("sideNavigation",function($scope,sideNav){
        $scope.sideNav = sideNav;
        $scope.sideNav.view = $scope.selectedLink = "<?php echo $params ?>";
        $scope.changeView = function(viewId){
            $scope.selectedLink = viewId;
            $scope.sideNav.view = viewId;
            setUrl(viewId);
            setTimeout(adjustFooter,200);
        }
        
    });
    
    
</script>
<nav id="sideNav" class="rounded-sm" ng-controller="sideNavigation">
    <ul>
        <?php 
        $first = 0;
        foreach($options as $locationName => $values){ 
            if($_SESSION['user_access_level']<$values[3]){$first++; continue;} ?>
        <li id="sidenav_<?php echo $first;?>" data-toggle="tooltip" title="<?php echo $values[1]; ?>" ng-class="{'activeLink':selectedLink === '<?php echo $locationName;?>','':selectedLink !== '<?php echo $locationName;?>'}"  ng-click="changeView('<?php echo $locationName ?>')"><span><i class="fa <?php echo $values[2]?>">&nbsp;&nbsp;&nbsp;&nbsp;</i><?php echo $values[0]; ?></span></li>
        <?php } ?>
    </ul>
</nav>

