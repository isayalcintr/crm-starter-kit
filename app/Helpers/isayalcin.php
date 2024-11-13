<?php
if (!function_exists('unique_code')) {
    function unique_code($limit = 8): string
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }
}
if (function_exists('array_keys_to_snake_case')) {
    function array_keys_to_snake_case(array $input): array
    {
        $result = [];
        foreach ($input as $key => $value) {
            $snakeKey = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $key));
            $result[$snakeKey] = $value;
        }
        return $result;
    }
}

