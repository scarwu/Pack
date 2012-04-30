<?php
/**
 * CSS Compress Example
 * 
 * @package		CssCompress
 * @author		ScarWu
 * @copyright	Copyright (c) 2012, ScarWu (http://scar.simcz.tw/)
 * @link		http://github.com/scarwu/CssCompress
 */
 
require_once '../src/CssCompress.php';

// Setting
/* You can use String or Array to set CSS files' folder or paths. */
$css_path_list = __DIR__ . DIRECTORY_SEPARATOR . 'css';
// $css_path_list = array(
	// __DIR__ . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'html5-boilerplate.css',
	// __DIR__ . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR . 'jquery-ui-1.8.19.custom.css'
// );

$output_filename = __DIR__ . DIRECTORY_SEPARATOR . 'package.css';

// Init Compressor
CssCompress::Init($css_path_list, $output_filename);

// Run Compressor
CssCompress::Run();
