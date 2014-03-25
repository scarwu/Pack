<?php
/**
 * HTML Pack Example
 *
 * @package     Pack
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pack
 */

$root = realpath(dirname(__FILE__) . '/..');

if (!file_exists("$root/tmp")) {
    mkdir("$root/tmp", 0755);
}

require "$root/vendor/autoload.php";

use ScarWu\Pack\HTML;

// Initialize HTML Packer
$html = new HTML();

$html->set("$root/example/html/express-jade-less-coffee-with-livereload.html");

// Pack HTML Files to output_html.html
$html->save("$root/tmp/output.html");
