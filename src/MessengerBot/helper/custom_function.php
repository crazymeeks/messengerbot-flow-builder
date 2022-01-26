<?php

/**
 * Parses a template argument to the specified value
 * Template variables are defined using double curly brackets: {{ [a-zA-Z] }}
 * Returns the query back once the instances has been replaced
 * 
 * @param string $string
 * @param string $find
 * @param string $replace
 * 
 * @return string
 * 
 * @throws \Exception
 */
if (!function_exists('findReplace')) {
    function findReplace($string, $find, $replace) {
        if (preg_match("/[a-zA-Z\_]+/", $find)) {
            return (string) preg_replace("/\{\{(\s+)?($find)(\s+)?\}\}/", $replace, $string);
        } else {
            throw new \Exception("Find statement must match regex pattern: /[a-zA-Z]+/");
        }
    }
}

if (!function_exists('is_multi_array')) {

    /**
     * Check if array is multidimensional
     *
     * @param array $hayhack
     * 
     * @return boolean
     */
    function is_multi_array(array $hayhack) {
        return isset($hayhack[0]) && is_array($hayhack[0]);
    }
}

if (!function_exists('vd')) {
    /**
     * Vardumper
     *
     * @param mixed $var
     * 
     * @return void
     */
    function vd($var) {
        echo "<pre>";
        print_r($var);
        exit;
    }
}