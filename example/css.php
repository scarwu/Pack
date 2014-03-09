<?php
/**
 * CSS Compress Example
 * 
 * @package     Pack
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pack
 */

$root = realpath(dirname(__FILE__));

if (!file_exists("$root/tmp")) {
    mkdir("$root/tmp", 0755);
}

require "$root/../src/Pack/CSS.php";

// Initialize CSS Packer
$css = new Pack\CSS([
    "$root/css/jquery-ui-1.8.19.custom.css",
    "$root/css/html5-boilerplate.css"
], "$root/tmp/output_css_a.css");

// Pack and Minify CSS Files to output_css_a.css
$css->pack();

// Clean CSS Source List
$css->clean();

// Add CSS File to List
$css->add("$root/css/normalize.css");

// Pack and Minify CSS File to output_css_b.css
$css->pack("$root/tmp/output_css_b.css");
