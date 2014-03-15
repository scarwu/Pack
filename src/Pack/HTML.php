<?php
/**
 * HTML Pack
 *
 * @package     Pack
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pack
 */

namespace Pack;

use Pack\JS;
use Pack\CSS;

class HTML
{
    /**
     * @var string
     */
    private $_path;

    public function __construct()
    {
        $this->_path = null;
    }

    /**
     * Set HTML
     *
     * @param string
     */
    public function set($path = null)
    {
        $this->_path = $path;
    }

    /**
     * @param string
     * @param string
     */
    public function get($html = '')
    {
        if ('' === $html) {
            if (file_exists($this->_path)) {
                $html = file_get_contents($this->_path);
            }
        }

        $this->_path = null;

        return $this->pack($html);
    }

    /**
     * Save HTML to File
     *
     * @param string
     */
    public function save($dest = null)
    {
        if (!file_exists(dirname($dest))) {
            mkdir(dirname($dest), 0755, true);
        }

        file_put_contents($dest, $this->get());
    }

    /**
     * Pack HTML
     */
    private function pack($html)
    {
        $in_tag = false;
        $in_quote = false;

        $in_script_tag = false;

        $in_style_tag = false;
        $in_style_attribute = false;

        $script = '';
        $style = '';

        $js_pack = new JS();
        $css_pack = new CSS();

        $html = str_replace(["\r\n", "\r"], "\n", $html);

        $chars = str_split($html);
        $result = '';

        foreach ($chars as $index => $char) {
            $pre_char = substr($result, -1);

            if ($in_tag && !$in_quote) {
                if ('"' === $char) {
                    // ' "'
                    if (' ' === $pre_char) {
                        $result = substr($result, 0, strlen($result) - 1);
                    }

                    $in_quote = true;

                    $result .= $char;
                    continue;
                }

                if ('>' === $char) {
                    // ' >'
                    if (' ' === $pre_char) {
                        $result = substr($result, 0, strlen($result) - 1);
                    }

                    $in_tag = false;

                    $result .= $char;
                    continue;
                }

                if ("\n" === $char || "\t" === $char) {
                    continue;
                }

                // '  '
                if (' ' === $pre_char && ' ' === $char) {
                    continue;
                }

                // '< '
                if ('<' === $pre_char && ' ' === $char) {
                    continue;
                }

                // ' ='
                if (' ' === $pre_char && '=' === $char) {
                    $result = substr($result, 0, strlen($result) - 1);
                }

                $result .= $char;
                continue;
            }

            if ($in_tag && $in_quote) {
                if ('"' === $char) {
                    $in_quote = false;
                }

                $result .= $char;
                continue;
            }

            if (!$in_tag && !$in_quote) {
                if ('<' === $char) {
                    // ' <'
                    if (' ' === $pre_char) {
                        $result = substr($result, 0, strlen($result) - 1);
                    }

                    $in_tag = true;

                    $result .= $char;
                    continue;
                }

                if ("\n" === $char || "\t" === $char) {
                    continue;
                }

                // '  '
                if (' ' === $pre_char && ' ' === $char) {
                    continue;
                }

                // '> '
                if ('>' === $pre_char && ' ' === $char) {
                    continue;
                }

                // ' <'
                if (' ' === $pre_char && '<' === $char) {
                    $result = substr($result, 0, strlen($result) - 1);
                }

                $result .= $char;
                continue;
            }
        }

        return $result;
    }
}
