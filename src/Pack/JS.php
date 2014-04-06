<?php
/**
 * JavaScript Pack
 *
 * @package     Pack
 * @author      ScarWu
 * @copyright   Copyright (c) 2012-2014, ScarWu (http://scar.simcz.tw/)
 * @link        http://github.com/scarwu/Pack
 */

namespace Pack;

class JS
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
     * Get Packed JavaScript
     *
     * @param string
     * @param boolean
     * @return string
     */
    public function get($js = null, $compress = true)
    {
        if (null === $js) {
            foreach ((array) $this->_list as $src) {
                if (!file_exists($src)) {
                    continue;
                }

                $js .= file_get_contents($src);
            }
        }

        $this->_list = [];

        return $compress ? $this->parse($js) : $js;
    }

    /**
     * Save JavaScript to File
     *
     * @param string
     * @param boolean
     */
    public function save($dest = null, $compress = true)
    {
        if (!file_exists(dirname($dest))) {
            mkdir(dirname($dest), 0755, true);
        }

        file_put_contents($dest, $this->get());
    }

    /**
     * Parse JavaScript
     *
     * @param string
     * @return string
     */
    private function parse($input)
    {
        $in_single_comment = false;
        $in_multiple_comment = false;

        $in_single_quote = false;
        $in_double_quote = false;

        $in_regex = false;

        $skip_char = [
            '(', ')', '{', '}', ',',
            '+', '-', '*', '/', '%',
            '|', '&', '=', '<', '>',
            '!', '?', ':', ';', '[',
            ']'
        ];

        $input = str_replace(["\r\n", "\r"], "\n", $input);
        $output = '';

        for ($i = 0;$i < strlen($input);$i++) {
            $char = substr($input, $i, 1);
            $pre_input_char = $i != 0 ? substr($input, $i - 1, 1) : null;
            $pre_output_char = substr($output, -1);

            /**
             * Handle comment block and check end tag
             */
            if ($in_single_comment) {
                if ("\n" === $char) {
                    $in_single_comment = false;
                }

                continue;
            }

            if ($in_multiple_comment) {
                if ('*/' === $pre_input_char . $char) {
                    $in_multiple_comment = false;
                }

                continue;
            }

            /**
             * Handle quote block and check end tag
             */
            if ($in_single_quote) {
                if ("'" === $char && '\\' !== $pre_output_char) {
                    $in_single_quote = false;
                }

                $output .= $char;
                continue;
            }

            if ($in_double_quote) {
                if ('"' === $char && '\\' !== $pre_output_char) {
                    $in_double_quote = false;
                }

                $output .= $char;
                continue;
            }

            /**
             * Check start tag of comment block
             */
            if ('//' === $pre_output_char . $char) {
                $in_single_comment = true;

                $output = substr($output, 0, strlen($output) - 1);
                continue;
            }

            if ('/*' === $pre_output_char . $char) {
                $in_multiple_comment = true;

                $output = substr($output, 0, strlen($output) - 1);
                continue;
            }

            /**
             * Check start tag of quote block
             */
            if ("'" === $char) {
                $in_single_quote = true;

                $output .= $char;
                continue;
            }

            if ('"' === $char) {
                $in_double_quote = true;

                $output .= $char;
                continue;
            }

            /**
             * Handle normal block
             */
            if ("\n" === $char || "\t" === $char) {
                continue;
            }

            if (' ' === $char && ' ' === $pre_output_char) {
                continue;
            }

            // i++ + ++i
            if ('+' === $char && ' ' === $pre_input_char && '+' === $pre_output_char) {
                $output .= " $char";
                continue;
            }

            // i-- - --i
            if ('-' === $char && ' ' === $pre_input_char && '-' === $pre_output_char) {
                $output .= " $char";
                continue;
            }

            if (' ' === $char && in_array($pre_output_char, $skip_char)) {
                continue;
            }

            if (' ' === $pre_output_char && in_array($char, $skip_char)) {
                $output = substr($output, 0, strlen($output) - 1);
            }

            $output .= $char;
        }

        return trim($output);
    }
}
