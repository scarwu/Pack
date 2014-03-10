<?php
/**
 * JavaScript Pack Example
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

require "$root/../src/Pack/JS.php";

// Initialize JavaScript Packer
$js = new Pack\JS();

// Append JavaScript List
$js->append([
    "$root/js/example.js",
    "$root/js/custom.js"
]);

// Pack JavaScript Files
$js->save("$root/tmp/output.js");
