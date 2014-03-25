<?php
/**
 * JavaScript Pack Example
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

use ScarWu\Pack\JS;

// Initialize JavaScript Packer
$js = new JS();

// Append JavaScript List
$js->append([
    "$root/example/js/jquery-2.1.0.js",
    "$root/example/js/modernizr-2.7.1.js"
]);

// Pack JavaScript Files
$js->save("$root/tmp/output.js");
