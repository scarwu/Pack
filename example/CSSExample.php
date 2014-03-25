<?php
/**
 * CSS Pack Example
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

// Initialize CSS Packer
$css = new Pack\CSS();

// Append CSS List
$css->append([
    "$root/example/css/font-awesome-4.0.3.css",
    "$root/example/css/html5-boilerplate-4.3.0.css"
]);

// Append CSS Path to List
$css->append("$root/example/normalize-1.1.3.css");

// Pack CSS File
$css->save("$root/tmp/output.css");

$text = <<<EOF
div .block{
    width: 100%;
    float: left;
}
EOF;

echo $css->get($text) . "\n";
echo $css->get('width: 90px; display: none;') . "\n";
