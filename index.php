<?php
session_start();
$protocol   = ($_SERVER['SERVER_PORT'] == '443'&&$_SERVER['HTTPS'] != '')?'https://':'http://';
define("ROOT" , realpath(dirname(__FILE__))."/");
define("ROOT_INCLUDES",ROOT."views/includes/");
define("ROOT_UPLOADS",ROOT."views/resources/uploads/");
define("ROOT_PARTIALS",ROOT."views/includes/partials/");
define("ROOT_IMAGES",ROOT."views/resources/images/");
define("ROOT_VIDEOS",ROOT."views/resources/videos/");
define("URL_PATH", $protocol.$_SERVER['SERVER_NAME']."/");
define("URL_IMAGES_PATH",URL_PATH."views/resources/images/");
define("URL_VIDEOS_PATH",URL_PATH."views/resources/videos/");
define("URL_JS_PATH",URL_PATH."views/resources/js/");
define("URL_PLUGINS",URL_PATH."views/resources/jsplugins/");
define("R_S",chr(0x1e));
define("U_S",chr(0x1f));

#Get the path of the current site
$siteFolder = "";
$siteUrl="";
if(preg_match("/(qapaq.com|qapaqsuperfoods.com)/i",$_SERVER['SERVER_NAME'])){
	$siteFolder = ROOT."apps/qapaq/";
	$siteUrl = URL_PATH."apps/qapaq/";
}
elseif(preg_match("/atlanticcleaningsvc.com/i",$_SERVER['SERVER_NAME'])){
	$siteFolder = ROOT."apps/atlanticcleaning/";
	$siteUrl = URL_PATH."apps/atlanticcleaning/";
}

define("ROOT_SITE_FOLDER",$siteFolder);
define("URL_SITE_PATH",$siteUrl);
define("URL_SITE_CSS",$siteUrl."css/site.min.css");
//const ACTIVE_APPS = array();
require_once('libs/bootstrap.php');
require_once('libs/controller.php');
require_once('libs/model.php');
require_once('libs/view.php');

error_reporting(E_ERROR | E_WARNING | E_PARSE);

try
{
	$app = new Bootstrap();
}
catch(Exception $e)
{
	echo $e->getMessage();
}

