CSS Compress
============

### Description

It can compress css file also can combine several css files.

### Requirement

* PHP 5.3+
* PHP-CLI (optional)

### How To Use

	<?php
	require_once '/path/to/CssCompress.php';
	
	// You can use String or Array to set CSS files' folder or paths.
	$css_path_list = '/path/to/css_folder';
	
	// Setting output path and filename
	$output_filename = '/path/to/output_filename.css';
	
	// Init Compressor
	CssCompress::Init($css_path_list, $output_filename);
	
	// Run Compressor
	CssCompress::Run();
	
#### Notice: If your css files have with license, please add it into the output file by manual