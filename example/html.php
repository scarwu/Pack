<?php
/**
 * HTML Pack Example
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

require "$root/../src/Pack/HTML.php";

// Initialize HTML Packer
$html = new Pack\HTML();

// Pack HTML Files to output_html.html
$html->pack("$root/html/index.html", "$root/tmp/output_html.html");
