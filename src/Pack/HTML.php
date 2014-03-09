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

class HTML
{
    /**
     * @var string
     */
    private $_html;

    public function __construct()
    {
        $this->_html = null;
    }

    /**
     * Set HTML
     *
     * @param string
     */
    public function setHTML($html = null)
    {
        $this->_html = $html;
    }

    /**
     * Clean
     */
    public function clean()
    {
        $this->_html = null;
    }

    /**
     * @param string
     * @param string
     */
    public function pack($src = null, $dest = null)
    {
        if (file_exists($src)) {
            $this->_html = file_get_contents($src);
        }

        if (null !== $this->_html) {
            $this->replace();
        }

        if (null === $dest) {
            return $this->_html;
        }

        if (!file_exists(dirname($dest))) {
            mkdir(dirname($dest), 0755, true);
        }

        file_put_contents($dest, $this->_html);
    }

    /**
     * Replace HTML
     */
    private function replace() {
        $in_tag = false;
        $in_quotation_mark = false;

        $chars = str_split($this->_html);
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

        $this->_html = $result;
    }
}
