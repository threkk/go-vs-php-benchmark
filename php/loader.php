<?php 

/**
 * Reads the route to the corpus file provided and loads every line as a string.
 *
 * @param {string} $route - Route of the corpus keys.
 * @return {array} Array of string.
 */
function loadX ($route)
{
    $file = file_get_contents($route);
    $lines = array_filter(explode(PHP_EOL, $file), function($line) {
        return $line !== '';
    });
    return $lines;
}


/**
 * Reads the route to the corpus file provided and loads every line as a tuple.
 *
 * @param {string} $route - Route of the corpus.
 * @return {array} Array of tuples.
 */
function loadCorpus($route)
{
    $file = file_get_contents($route);
    $lines = array_filter(explode(PHP_EOL, $file), function($line) {
        return $line !== '';
    });
    $entries = [];
    foreach ($lines as $line) {
        $entry = explode(' ', $line);
        $entries[] = [
            'x' => $entry[0],
            'y' => intval($entry[1]),
            'value' => $entry[2]
        ];
    }

    shuffle($entries);
    return $entries;
}

// End of loader.php
