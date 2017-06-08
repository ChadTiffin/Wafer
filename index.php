<?php
/**
* WAFER FRONT CONTROLLER FRAMEWORK
* Chad Tiffin May 18, 2017
*/

/**
* There should be no need to change anything in this file! Everything should be done
* in either config.php, routes.php, or your view files.
**/

$no_ext = "";

include("routes.php");

//allows a page to be included into main template
function getPageContent()
{

	if (GENERATE_STATIC) {
		$page = $GLOBALS['no_ext'];
	}
	else {
		$page = "index.php";
		if (isset($_GET['page']))
			$page = $_GET['page'];
	}
	if (isset($GLOBALS['route'][$page]))
		extract($GLOBALS['route'][$page]);

	if (file_exists(VIEW_FOLDER.$page.".php")) 
		include(VIEW_FOLDER.$page.".php");
	else 
		include(VIEW_FOLDER."404.php");
}

include("config.php");

if (ENVIRONMENT == 'dev') {
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
}

//include dependencies
foreach (DEPENDENCIES as $dep) {
	include($dep);
}

if (GENERATE_STATIC) {
	//loop through each view file and write to file as an html page
	$output_list = "";

	$dir = new DirectoryIterator(VIEW_FOLDER);

	
	foreach ($dir as $fileinfo) {
		$filename = $fileinfo->getFilename();
		
		$skip = false;
		//echo "ext: ".$fileinfo->getExtension()."<br>";
		if ($fileinfo->getExtension() == "php") {
			//make sure this is not a template view
			
			foreach ($route as $route_page) {
				if (isset($route_page['template']) || $filename==MAIN_TEMPLATE) {
					$skip = true;
					break;
				}
			}
		}
		else {
			$skip = true;
		}

		//run this file and save output to static file
		if (!$skip) {
			$no_ext = pathinfo($filename, PATHINFO_FILENAME);

			$output_list .= "<li>".$no_ext.".html</li>";

			$main_template = MAIN_TEMPLATE;

			//load the route
			if (isset($route[$no_ext]['template']))
				$main_template = $route[$no_ext]['template'];

			ob_start();

			$page = $no_ext;

			unset($route['template']);

			if (isset($route[$page]))
				extract($route[$page]);

			include(VIEW_FOLDER.$main_template);

			$output = ob_get_clean();
		
			ob_clean();

			$file_path = "index.html";
			file_put_contents("static/".$no_ext.".html", $output);
		
		}
	}
	ob_end_clean();

	echo  "<p>Static Pages Generated in /static directory: </p><ul>".$output_list."</ul>";
	echo "<p>To turn this off, go to config.php and set GENERATE_STATIC to false</p>";
}
else {
	$page = "index";
	if (isset($_GET['page']))
		$page = $_GET['page'];

	//404 handling
	if (!file_exists(VIEW_FOLDER.$page.".php"))
		header("HTTP/1.0 404 Not Found");

	$main_template = MAIN_TEMPLATE;

	//load the route
	if (isset($route[$page]['template']))
		$main_template = $route[$page]['template'];

	unset($route['template']);
	extract($route[$page]);

	//Away we go... 
	include(VIEW_FOLDER.$main_template);
}