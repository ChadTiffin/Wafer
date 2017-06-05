<?php
/**
* WAFER FRONT CONTROLLER FRAMEWORK
* Chad Tiffin May 18, 2017
*/

/**
* There should be no need to change anything in this file! Everything should be done
* in either config.php, routes.php, or your view files.
**/

//allows a page to be included into main template
function getPageContent()
{

	if (isset($_GET['page']) && file_exists(VIEW_FOLDER.$_GET['page'].".php")) 
		include(VIEW_FOLDER.$_GET['page'].".php");
	elseif (!isset($_GET['page']))
		include(VIEW_FOLDER."index.php");
	else 
		include(VIEW_FOLDER."404.php");
}

function getPageVariable($var)
{
	if (isset($var)) 
		echo $var;
}

include("config.php");

if (ENVIRONMENT == 'dev') {
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
}

$page = "index";
if (isset($_GET['page']))
	$page = $_GET['page'];

//404 handling
if (!file_exists(VIEW_FOLDER.$page.".php"))
	header("HTTP/1.0 404 Not Found");

//include dependencies
foreach (DEPENDENCIES as $dep) {
	include($dep);
}

include("routes.php");

$main_template = MAIN_TEMPLATE;

//load the route
if (isset($route[$page]['template']))
	$main_template = $route[$page]['template'];

unset($route['template']);
extract($route[$page]);

if (GENERATE_STATIC) 
	ob_start();

//Away we go... 
include(VIEW_FOLDER.MAIN_TEMPLATE);

//write static site files
if (GENERATE_STATIC) {
	$output = ob_get_clean();
	ob_end_flush();

	$file_path = "index.html";
	file_put_contents("static/".$page.".html", $output);

	echo  "<p>Static Page Generated: <a href='static/".$page.".html'>/static/".$page.".html</a></p>";
	echo "<p>To turn this off, go to config.php and set GENERATE_STATIC to false</p>";
}