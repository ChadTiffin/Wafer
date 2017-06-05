# Wafer
A super-lightweight front end controller framework &amp; static site generator for static websites

## Welcome to Wafer

_Wafer_ is a super-lightweight Front End Controller designed to make the building of static websites cleaner and easier to maintain, eliminating the need for physical page files that demand the use of header/footer includes.

## Usage

Wafer enables the use of a single 'template' layout file, which can then pull in page content and insert it within the main template. By default the main template file is located in '/views/template.php'. Subpage fragments should also be stored in the 'views' folder. The name of your views folder and main template file can be changed in config.php

### Routing

Just like a regular static website, their filename will be represented as url path.

For example, www.yoursite.com/about-us will route to 'views/template.php', with 'views/about-us.php' inserted into it.

If you want to add templated variables to your main template, you do so in the routes.php file:
~~~~
    <?php 

    $route['about-us'] = [
    	'title' => 'This is a variable for the about-us page',
    	'framework' => 'Wafer'
    ];
~~~~

Wafer will then map these to variables in the template view when www.yoursite.com/about-us is loaded.
~~~~
    <h2>About Us</h2>
    <p>This is an example subpage</p>
    <p>(A page by the <?=framework?>)</p>
~~~~
If you want to use a different main template for a certain page, simply declare it in your route as the 'template' index:
~~~~
    <?php 

    $route['about-us'] = [
    	'template' => 'subpage_template.php',
    	'title' => 'This is a variable for the about-us page',
    	'framework' => 'Wafer'
    ];
~~~~
Wafer will then use 'subpage_template.php' as the main template for that page instead of your default one.

### Templating

Your main 'template.php' file should contain a php function called getPageContent(). Where you place this function in your template file will determine where the page content get's inserted:

template.php
~~~~
    <html>
    <head>
    	<title><?= $title; ?></title>
    </head>
    <body>
    	<header>
    		<h1>Wafer</h1>
    		<nav></header>
    	<div class="main" role>
    		<?php 
    		//Include this function where you want to pull in your page view
    		getPageContent(); ?>
    	</div>

    </body>
    </html>
~~~~
### Config

Some things can be changed by editing the 'config.php' file:

*   Location/name of the 'views' folder
*   Name of your master template
*   PHP Dependencies
*   Static site generation

#### Dependencies

In Wafer, the subpage views are actually loaded BEFORE the main template in PHP, so if you have any dependencies, they should go into config.php in the DEPENDENCIES array constant.
~~~~
    /**********************************
    * DEPENDENCIES: This can be used to make sure any PHP includes are inserted before the main template loads
    **********************************/
    const DEPENDENCIES = [
    	'path/to/libary_file.php',
    	'another/path/libary_file.php',
    ];
~~~~
### Static Site Generation

By default Wafer is intended to be run on the server as a semi-dynamic website -- meaning the server compiles your templates & sub-views into an html page each time a page is requested by the client. However it can also be used as a simple static site generator to pre-compile your pages and improve performance.

In config.php, simply set the GENERATE_STATIC constant to TRUE. Now when you visit a page, it will save the compiled page into the '/static' folder as an html file. You can then upload this file to your server as a static page.
