<?php

if (!function_exists('array_key_max')) {
    /**
     * Mengembalikan key dari nilai terbesar dalam array
     *
     * @param array $array
     * @return int|string|null
     */
    function array_key_max(array $array)
    {
        if (empty($array)) {
            return null;
        }
        $maxValue = max($array);
        return array_search($maxValue, $array);
    }
}