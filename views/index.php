<h2>Welcome to Wafer</h2>
<p><em>Wafer</em> is a super-lightweight Front End Controller designed to make the building of static websites cleaner and easier to maintain, eliminating the need for physical page files that demand the use of header/footer includes.</p>

<h2>Usage</h2>

<p>Wafer enables the use of a single 'template' layout file, which can then pull in page content and insert it within the main template. By default the main template file is located in '/views/template.php'. Subpage fragments should also be stored in the 'views' folder. The name of your views folder and main template file can be changed in config.php</p>

<h3>Routing</h3>

<p>Just like a regular static website, their filename will be represented as url path.</p>
<p>For example, www.yoursite.com/about-us will route to 'views/template.php', with 'views/about-us.php' inserted into it.</p>

<p>If you want to add templated variables to your main template, you do so in the routes.php file:</p>

<pre><code>
&lt;?php 

$route['about-us'] = [
	'title' => 'This is a variable for the about-us page',
	'framework' => 'Wafer'
];
</code></pre>

<p>Wafer will then map these to variables in the template view when www.yoursite.com/about-us is loaded.</p>

<pre><code>
&lt;h2>About Us&lt;/h2>
&lt;p>This is an example subpage&lt;/p>
&lt;p>(A page by the &lt;?=framework?&gt;)&lt;/p>
</code></pre>

<p>If you want to use a different main template for a certain page, simply declare it in your route as the 'template' index:</p>

<pre><code>
&lt;?php 

$route['about-us'] = [
	'template' => 'subpage_template.php',
	'title' => 'This is a variable for the about-us page',
	'framework' => 'Wafer'
];
</code></pre>

<p>Wafer will then use 'subpage_template.php' as the main template for that page instead of your default one.</p>

<h3>Templating</h3>

<p>Your main 'template.php' file should contain a php function called getPageContent(). Where you place this function in your template file will determine where the page content get's inserted:</p>

template.php
<pre><code>
&lt;html>
&lt;head>
	&lt;title>&lt;?= $title; ?&gt;&lt;/title>
&lt;/head>
&lt;body>
	&lt;header>
		&lt;h1>Wafer&lt;/h1>
		&lt;nav>&lt;/header>
	&lt;div class="main" role>
		&lt;?php 
		//Include this function where you want to pull in your page view
		getPageContent(); ?&gt;
	&lt;/div>
	
&lt;/body>
&lt;/html>
</code></pre>

<h3>Config</h3>

<p>Some things can be changed by editing the 'config.php' file:</p>

<ul>
	<li>Location/name of the 'views' folder</li>
	<li>Name of your master template</li>
	<li>PHP Dependencies</li>
	<li>Static site generation</li>
</ul>

<h4>Dependencies</h4>

<p>In Wafer, the subpage views are actually loaded BEFORE the main template in PHP, so if you have any dependencies, they should go into config.php in the DEPENDENCIES array constant.</p>

<pre><code>
/**********************************
* DEPENDENCIES: This can be used to make sure any PHP includes are inserted before the main template loads
**********************************/
const DEPENDENCIES = [
	'path/to/libary_file.php',
	'another/path/libary_file.php',
];
</code></pre>

<h3>Static Site Generation</h3>

<p>By default Wafer is intended to be run on the server as a semi-dynamic website -- meaning the server compiles your templates &amp; sub-views into an html page each time a page is requested by the client. However it can also be used as a simple static site generator to pre-compile your pages and improve performance.</p>

<p>In config.php, simply set the GENERATE_STATIC constant to TRUE. Now when you visit a page, it will save the compiled page into the '/static' folder as an html file. You can then upload this file to your server as a static page.</p>