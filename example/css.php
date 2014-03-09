<?php
/**
 * CSS Pack Example
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
$css = new Pack\CSS();

// Append CSS List
$css->append([
    "$root/css/jquery-ui-1.8.19.custom.css",
    "$root/css/html5-boilerplate.css"
]);

// Append CSS Path to List
$css->append("$root/css/normalize.css");

// Pack CSS File
$css->save("$root/tmp/output.css");
