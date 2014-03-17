<?php
/**
 * CSS Pack
 *
 * @package     Pack
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pack
 */

namespace Pack;

class CSS
{
    /**
     * @var array
     */
    private $_list;

    /**
     * @param array
     * @param string
     */
    public function __construct()
    {
        $this->_list = [];
    }

    /**
     * Append Path or List to List
     *
     * @param string
     * @return object
     */
    public function append($list = null)
    {
        if (is_string($list)) {
            $this->_list[] = $list;
        }

        if (is_array($list)) {
            $this->_list = array_merge($this->_list, $list);
        }

        return $this;
    }

    /**
     * Get Packed CSS
     *
     * @return string
     */
    public function get($css = '')
    {
        if ('' === $css) {
            foreach ((array) $this->_list as $src) {
                if (!file_exists($src)) {
                    continue;
                }

                $css .= file_get_contents($src);
            }
        }

        $this->_list = [];

        return $this->parse($css);
    }

    /**
     * Save CSS to File
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
     * Parse CSS
     *
     * @param string
     * @return string
     */
    private function parse($css)
    {
        $in_comment = false;

        $in_single_quote = false;
        $in_double_quote = false;

        $skip_char = [
            '{', '}', '[', ']', ',',
            ':', ';', '+', '=', '!',
            '~', '>', '"', "'"
        ];

        $css = str_replace(["\r\n", "\r"], "\n", $css);

        $chars = str_split($css);
        $result = '';

        foreach ($chars as $index => $char) {
            $pre_char = substr($result, -1);

            /**
             * Handle comment block and check end tag
             */
            if ($in_comment) {
                if ('*/' === $chars[$index - 1] . $char) {
                    $in_comment = false;
                }

                continue;
            }

            /**
             * Handle quote block and check end tag
             */
            if ($in_single_quote) {
                if ("'" === $char && '\\' !== $pre_char) {
                    $in_single_quote = false;
                }

                $result .= $char;
                continue;
            }

            if ($in_double_quote) {
                if ('"' === $char && '\\' !== $pre_char) {
                    $in_double_quote = false;
                }

                $result .= $char;
                continue;
            }

            /**
             * Check start tag of comment block
             */
            if ('/*' === $pre_char . $char) {
                $in_comment = true;

                $result = substr($result, 0, strlen($result) - 1);
                continue;
            }

            /**
             * Check start tag of quote block
             */
            if ("'" === $char) {
                if (' ' === $pre_char) {
                    $result = substr($result, 0, strlen($result) - 1);
                }

                $in_single_quote = true;

                $result .= $char;
                continue;
            }

            if ('"' === $char) {
                if (' ' === $pre_char) {
                    $result = substr($result, 0, strlen($result) - 1);
                }

                $in_double_quote = true;

                $result .= $char;
                continue;
            }

            /**
             * Handle normal block
             */
            if ("\n" === $char || "\t" === $char) {
                continue;
            }

            if (' ' === $pre_char && ' ' === $char) {
                continue;
            }

            if (' ' === $pre_char && in_array($char, $skip_char)) {
                $result = substr($result, 0, strlen($result) - 1);
            }

            if (' ' === $char && in_array($pre_char, $skip_char)) {
                continue;
            }

            $result .= $char;
        }

        return trim($result);
    }
}
