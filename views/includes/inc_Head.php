<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<?php
$files = scandir(ROOT."views/resources/css");
foreach ($files as $file)
{
    if(!is_dir(ROOT."views/resources/css/".$file))
    {
    ?>
        <link rel="stylesheet" type="text/css" href="<?php echo URL_PATH."views/resources/css/".$file?>"/>
    <?php
    }
}
?>

    <link rel="stylesheet" type="text/css" href="<?php echo URL_PLUGINS?>slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URL_PLUGINS?>slick/slick-theme.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo URL_SITE_CSS?>" />
    <base href="<?php echo URL_PATH ?>"/>
    <meta charset="utf-8"/>
    <meta name="keywords" content="<?php echo $params['keywords']?>" />
    <meta name="description" content="<?php echo $params['description']?>" />
    <meta name="revised"  />
    <title><?php echo $params['title']?></title>


    <!--[if lt IE 9]>
    <script src="<?php echo URL_JS_PATH?>jquery-1.11.3.min.js"></script>
    <![endif]-->

    <!--[if gte IE 9]-->
    <script src="<?php echo URL_JS_PATH?>jquery-2.1.4.min.js"></script>
    <!--[endif]-->
    <script type="text/javascript" src="<?php echo URL_JS_PATH?>angular.min.js"></script>
    <script type="text/javascript" src="<?php echo URL_JS_PATH?>angular-animate.min.js"></script>
    <script type="text/javascript" src="<?php echo URL_JS_PATH?>bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo URL_JS_PATH?>mainControls.js"></script>
    <script type="text/javascript" src="<?php echo URL_PLUGINS?>slick/slick.min.js"></script>

<script type="text/javascript"> 
    if (typeof (Storage) !== "undefined") {
            if(sessionStorage.windowId){
               //The windows session id is allready set.
              
            }
            else{
                sessionStorage.windowId = "<?php echo md5(microtime());?>";
            }
        } else {
           window.alert("This browser is unsuported please use a newer browser as in Google Chrome, Firefox, Microsoft Edge, or Safari");
        }
        
        
</script>
    <script type="text/javascript">
        rootApp.controller("siteCtrl",function($scope,$http){
            $scope.pagejson = <?php echo $params['pagejson']?>;
            $scope.sections = $scope.pagejson.sections;
            $scope.contactForm = $scope.pagejson.contact_form;
            $scope.contactInformation = $scope.pagejson.contact_information;
            //$scope.sections = <?php echo json_encode($params['sections'])?>;
            //$scope.contactForm = <?php echo json_encode($params['contact_form'])?>;
            //$scope.contactInformation = <?php echo json_encode($params['contact_information'])?>;
        });
    </script>


</head>
<body ng-app="rootApp" ng-controller="siteCtrl" data-spy="scroll" data-target="#main-nav">

    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3&libraries=places"></script>
    <?php require(ROOT."views/includes/inc_Header.php");?>
    <div class="maincontent" >

