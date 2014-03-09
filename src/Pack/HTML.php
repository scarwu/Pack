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
    public function save($dest = null) {
        if (!file_exists(dirname($dest))) {
            mkdir(dirname($dest), 0755, true);
        }

        file_put_contents($dest, $this->get());
    }

    /**
     * Pack HTML
     */
    private function pack($html) {
        $in_tag = false;
        $in_quotation_mark = false;

        $chars = str_split($html);
        $result = '';

        foreach ($chars as $index => $char) {
            $pre_char = substr($result, -1);

            if (isset($chars[$index + 1])) {
                $next_char = $chars[$index + 1];
            } else {
                $next_char = null;
            }

            if ('<' === $char && !$in_tag ) {
                $in_tag = true;
                $result .= $char;

                continue;
            }

            if ('>' === $char && $in_tag) {
                $in_tag = false;
                $result .= $char;

                continue;
            }

            if ('"' === $char && $in_tag) {
                $in_quotation_mark = !$in_quotation_mark;
                $result .= $char;

                continue;
            }

            if ($in_tag && !$in_quotation_mark) {
                if (in_array($pre_char, [' ', '=']) && ' ' === $char) {
                    continue;
                }

                if (in_array($next_char, ['"', '=']) && ' ' === $char) {
                    continue;
                }

                if (preg_match('/[\r\t\n\f]/', $char)) {
                    if (' ' !== $pre_char) {
                        $result .= ' ';
                    }
                    
                    continue;
                }

                $result .= $char;
            }

            if ($in_tag && $in_quotation_mark) {
                if (in_array($pre_char, ['"', ';' ,'=']) && ' ' === $char) {
                    continue;
                }

                if (in_array($next_char, ['"', ';' ,'=', ' ']) && ' ' === $char) {
                    continue;
                }

                $result .= $char;
            }

            if (!$in_tag) {
                if ('>' === $pre_char && ' ' === $char) {
                    continue;
                }

                if ('<' === $next_char && ' ' === $char) {
                    continue;
                }

                if (preg_match('/[\r\t\n\f]/', $char)) {
                    continue;
                }

                $result .= $char;
            }
        }

        return $result;
    }
}
