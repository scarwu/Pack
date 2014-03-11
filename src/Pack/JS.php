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
     * @return string
     */
    public function get($js = '')
    {
        if ('' === $js) {
            foreach ((array) $this->_list as $src) {
                if (!file_exists($src)) {
                    continue;
                }

                $js .= file_get_contents($src);
            }
        }

        $this->_list = [];

        return $this->pack($js);
    }

    /**
     * Save JavaScript to File
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
     * Pack JavaScript
     *
     * @param string
     * @return string
     */
    private function pack($js)
    {
        $in_comment = false;
        $in_quote = false;

        $comment_type = null; // 1 = single, 2 = multiple
        $quote_type = null; // 1 = single, 2 = double

        $chars = str_split($js);
        $result = '';

        foreach ($chars as $index => $char) {
            $pre_char = substr($result, -1);

            if (isset($chars[$index + 1])) {
                $next_char = $chars[$index + 1];
            } else {
                $next_char = null;
            }

            if (!$in_comment && !$in_quote) {
                if ('//' === $pre_char . $char) {
                    $in_comment = true;
                    $comment_type = 1;
                    $result = substr($result, 0, strlen($result) - 1);

                    continue;
                }

                if ('/*' === $pre_char . $char) {
                    $in_comment = true;
                    $comment_type = 2;
                    $result = substr($result, 0, strlen($result) - 1);

                    continue;
                }

                if ("'" === $char) {
                    $in_quote = true;
                    $quote_type = 1;
                    $result .= $char;

                    continue;
                }

                if ('"' === $char) {
                    $in_quote = true;
                    $quote_type = 2;
                    $result .= $char;
                    
                    continue;
                }

                if (in_array($char, ["\n", "\r", "\t"])) {
                    continue;
                }



                $result .= $char;
            }

            if ($in_comment) {
                if (1 === $comment_type) {
                    if ("\n" === $char) {
                        $in_comment = false;
                        $comment_type = null;

                        continue;
                    }
                }

                if (2 === $comment_type) {
                    if ('*/' === $chars[$index - 1] . $char) {
                        $in_comment = false;
                        $comment_type = null;

                        continue;
                    }
                }
            }

            if ($in_quote) {
                $result .= $char;

                if (1 === $quote_type) {
                    if ("'" === $char && '\\' !== $pre_char) {
                        $in_quote = false;
                        $quote_type = null;

                        continue;
                    }
                }

                if (2 === $quote_type) {
                    if ('"' === $char && '\\' !== $pre_char) {
                        $in_quote = false;
                        $quote_type = null;

                        continue;
                    }
                }
            }

        }

        return $result;
    }
}
