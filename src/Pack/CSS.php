<?php
/**
 * CSS Compress
 *
 * @package     Pack
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pack
 */

use Pack;

class CSS
{
    /**
     * @var array
     */
    private $_list;

    public function __construct($list = [], $dest = null)
    {
        if (is_array($list)) {
            $this->_list = $list;
        }

        if (is_string($dest)) {
            $this->_dest = $dest;
        }
    }

    public function add($src = null)
    {
        if (is_string($src)) {
            $this->_list[] = $src;
        }
    }

    /**
     * Css IO Setting
     *
     * @param string
     * @param string
     */
    public function pack($dest = null)
    {
        if (null !== $dest) {
            $this->_dest = $dest;
        }

        if (!file_exists($this->_dest)) {
            return false;
        }

        $handle = fopen($this->_dest, 'w+');
        foreach ((array) $this->_list as $source) {
            if (!file_exists($source)) {
                continue;
            }

            $css = file_get_contents($source);
            $css = $this->replace($css);

            fwrite($handle, $css);
        }
        fclose($handle);
    }

    /**
     * Replace Character
     *
     * @param string
     * @return string
     */
    private function replace($css)
    {
        $css = preg_replace('/(\f|\n|\r|\t|\v)/', '', $css);
        $css = preg_replace('/\/\*.+?\*\//', '', $css);
        $css = preg_replace('/[ ]+/', ' ', $css);
        $css = str_replace([
            ' ,', ', ', ': ', ' :',
            ' {', '{ ', ' }', '} ',
            ' ;', '; '
        ], [
            ',', ',', ':', ':',
            '{', '{', '}', '}',
            ';', ';'
        ], $css);

        return $css;
    }
}
