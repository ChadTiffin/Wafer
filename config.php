<?php

/**********************************
* VIEW FOLDER: Relative path to where page views and template are stored. INCLUDE TRAILING SLASH
**********************************/
const VIEW_FOLDER = 'views/';  

/**********************************
* MAIN TEMPLATE: View file of main template
**********************************/
const MAIN_TEMPLATE = 'template.php';

/**********************************
* DEPENDENCIES: This can be used to make sure any PHP includes are inserted before the main template loads
**********************************/
const DEPENDENCIES = [
	//'path/to/libary_file.php'
];

/**********************************
* ENVIRONMENT: Setting this to 'dev' will turn on error reporting
**********************************/
const ENVIRONMENT = 'dev';

/**********************************
* STATIC GENERATOR: Setting this to true will write the static site files into the '/static' folder
**********************************/
const GENERATE_STATIC = false;