<?php

namespace TextCvs;

class Utils
{
    /**
     * Combines an array
     * 
     * @param array $first
     * @param array $second
     * @param string $replacement
     * @param boolean $order Whether to merge first with second or vice versa
     * @return array
     */
    public static function arrayCombine(array $first, array $second, $replacement = null, $order = true)
    {
        // Fix for different length
        if (count($first) !== count($second)) {
            $input = array($first, $second);
            $count = array_map('count', $input);

            // Find the largest and lowest array index
            $min = array_keys($count , max($count));
            $max = array_keys($count , min($count));

            // Find indexes
            $min = $min[0];
            $max = $max[0];

            $largest = $input[$min];
            $smallest = $input[$max];

            // Now fix the length
            foreach ($largest as $key => $value) {
                if (!isset($smallest[$key])) {
                    $smallest[$key] = $replacement; 
                }
            }

            $first = $smallest;
            $second = $largest;
        }

        if ($order === true) {
            return array_combine($second, $first);
        } else {
            return array_combine($first, $second);
        }
    }

    /**
     * Explodes a text into sentences
     * 
     * @param string $text
     * @return array
     */
    public static function explodeText($text)
    {
        return self::extraExplode($text, array('!', '?', '.', "\r"));
    }

    /**
     * Explodes a string supporting several delimiters and keeping them
     * 
     * @param string $explode
     * @param array $delimiters
     * @return array
     */
    public static function extraExplode($string, array $delimiters)
    {
        // Ensure special characters are escaped
        foreach ($delimiters as &$delimiter) {
            $delimiter = preg_quote($delimiter);
        }

        // RegEx fragment with delimiters
        $fragment = implode('|', $delimiters);
        $regEx = sprintf('@(?<=%s)@', $fragment);

        return preg_split($regEx, $string, -1, PREG_SPLIT_DELIM_CAPTURE);
    }
}
