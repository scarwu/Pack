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
    public function get($html = null)
    {
        if (null === $html) {
            if (file_exists($this->_path)) {
                $html = file_get_contents($this->_path);
            }
        }

        $this->_path = null;

        return $this->parse($html);
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
     * Parse HTML
     */
    private function parse($input)
    {
        $in_tag = false;
        $in_quote = false;

        $in_script_tag = false;

        $in_style_tag = false;
        $in_style_attribute = false;

        $text = '';

        $js_pack = new JS();
        $css_pack = new CSS();

        $input = str_replace(["\r\n", "\r"], "\n", $input);
        $output = '';

        for ($i = 0;$i < strlen($input);$i++) {
            $char = substr($input, $i, 1);
            $pre_input_char = $i != 0 ? substr($input, $i - 1, 1) : null;
            $pre_output_char = substr($output, -1);

            if ($in_tag && !$in_quote) {
                if ('"' === $char) {
                    // ' "'
                    if (' ' === $pre_output_char) {
                        $output = substr($output, 0, strlen($output) - 1);
                    }

                    $in_quote = true;

                    $output .= $char;
                    continue;
                }

                if ('>' === $char) {
                    // ' >'
                    if (' ' === $pre_output_char) {
                        $output = substr($output, 0, strlen($output) - 1);
                    }

                    $in_tag = false;

                    $output .= $char;
                    continue;
                }

                if ("\n" === $char || "\t" === $char) {
                    continue;
                }

                // '  '
                if (' ' === $pre_output_char && ' ' === $char) {
                    continue;
                }

                // '< '
                if ('<' === $pre_output_char && ' ' === $char) {
                    continue;
                }

                // ' ='
                if (' ' === $pre_output_char && '=' === $char) {
                    $output = substr($output, 0, strlen($output) - 1);
                }

                // ' /'
                if (' ' === $pre_output_char && '/' === $char) {
                    $output = substr($output, 0, strlen($output) - 1);
                }

                $output .= $char;
                continue;
            }

            if ($in_tag && $in_quote) {
                if ('"' === $char) {
                    $in_quote = false;
                }

                $output .= $char;
                continue;
            }

            if (!$in_tag && !$in_quote) {
                if ('<' === $char) {
                    // ' <'
                    if (' ' === $pre_output_char) {
                        $output = substr($output, 0, strlen($output) - 1);
                    }

                    $in_tag = true;

                    $output .= $char;
                    continue;
                }

                if ("\n" === $char || "\t" === $char) {
                    continue;
                }

                // '  '
                if (' ' === $pre_output_char && ' ' === $char) {
                    continue;
                }

                // '> '
                if ('>' === $pre_output_char && ' ' === $char) {
                    continue;
                }

                // ' <'
                if (' ' === $pre_output_char && '<' === $char) {
                    $output = substr($output, 0, strlen($output) - 1);
                }

                $output .= $char;
                continue;
            }
        }

        return trim($output);
    }
}
