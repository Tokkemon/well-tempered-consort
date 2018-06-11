<?php
//The main Index Page


//Set up the global variables.
$site_path = dirname(__FILE__) . '/';
$site_url = 'http://localhost/wtc/';
$site_name = 'Well-Tempered Consort';
$template_path = $site_path . 'template/';
$template_url = $site_url . 'template/';

//Do database connection stuff here.

//Include the Helpers
require($site_path . 'helper.php');

//All the Pages for the Menu
$menu_pages = [
	[
		'link' => '#about',
		'title' => 'About'
	],
	[
		'link' => 'build',
		'title' => 'Build'
	],
	[
		'link' => 'contact',
		'title' => 'Contact'
	]
];

//Parse the URL.
$page_request = (isset($_GET['page']) ? $_GET['page'] : 'home');
$page_params = array_values(array_filter(explode("/", (isset($_GET['path']) ? $_GET['path'] : ''))));

//Page Header
require($template_path . "head.php");
//Nav bar
require($template_path . "nav.php");

//Based on the page, send it to the correct php block page.
//TODO: Replace this whole thing with a router, json or db?
$template_blocks = [
	[
		"url" => "home",
		"title" => "",
		"block" => "home"
	],
	[
		"url" => "build",
		"title" => "Build Your Ensemble",
		"block" => "build"
	],
	[
		"url" => "pieces",
		"title" => "Pieces",
		"block" => "pieces"
	]
];
//TODO: 404
foreach($template_blocks as $block) {
	if($page_request == $block['url']) {
		$page_name = $block['title'];
		include($template_path . $block['block'] . '.php');
		break;
	}
}

//Footer
require($template_path . 'footer.php');	