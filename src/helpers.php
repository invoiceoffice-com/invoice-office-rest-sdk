<?php

if (!function_exists('build_query_string')) {
    /**
     * Generate a query string.
     */
    function build_query_string(array $params = [], int $encoding = PHP_QUERY_RFC3986): string
    {
        if (empty($params)) {
            return '';
        }

        $query = '';
        foreach ($params as $key => $value) {
            if (empty($value)) {
                continue;
            }

            if (is_array($value)) {
                $query .= build_batch_query_string($key, $value, $encoding);

                continue;
            }

            $parameter = url_encode($key, $encoding);
            $propertyValue = is_bool($value) ? 'true' : url_encode($value, $encoding);
            $query .= "&{$parameter}={$propertyValue}";
        }

        return $query ?: '';
    }
}

if (!function_exists('build_batch_query_string')) {
    /**
     * Generate a query string for batch requests.
     *
     * @param string $key   the name of the query variable
     * @param array  $items an array of item values for the variable
     */
    function build_batch_query_string(string $key, array $items, int $encoding = PHP_QUERY_RFC3986): string
    {
        return array_reduce($items, static function ($query, $item) use ($key, $encoding) {
            return $query . '&' . url_encode($key, $encoding) . '=' . url_encode($item, $encoding);
        }, '');
    }
}

if (!function_exists('url_encode')) {
    /**
     * Url encode a string.
     */
    function url_encode(string $value, $encoding = PHP_QUERY_RFC3986): string
    {
        return match ($encoding) {
            false             => $value,
            PHP_QUERY_RFC3986 => rawurlencode($value),
            PHP_QUERY_RFC1738 => urlencode($value),
            default           => throw new InvalidArgumentException('Invalid type'),
        };
    }
}

if (!function_exists('ms_timestamp')) {
    /**
     * Get a millisecond timestamp from a date or time.
     */
    function ms_timestamp(mixed $time): mixed
    {
        return match (true) {
            $time instanceof \DateTime                         => $time->getTimestamp() * 1000,
            is_numeric($time) && 10 === strlen((string) $time) => $time * 1000,
            is_string($time)                                   => strtotime($time) * 1000,
            default                                            => $time,
        };
    }
}
