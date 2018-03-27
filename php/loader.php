<?php 

/**
 * Reads the route to the corpus file provided and loads every line as a string.
 *
 * @param {string} $route - Route of the corpus keys.
 * @return {array} Array of string.
 */
function loadX ($route)
{
    /* $dir = realpath(dirname(__FILE__).'/../').$route; */
    $handler = fopen($route, 'r');
    $lines = [];
    if ($handler) {
        while(($line = fgets($handler)) !== false) {
            if ($line !== '') {
                $lines[] = $line;
            }
        }
        fclose($handler);
    }
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
    /* $dir = realpath(dirname(__FILE__).'/../').$route; */
    $handler = fopen($route, 'r');
    $entries = [];

    if ($handler) {
        while(($line = fgets($handler)) !== false) {
            if ($line !== '') {
                $entry = explode(' ', $line);
                $entries[] = [
                    'x' => $entry[0],
                    'y' => intval($entry[1]),
                    'value' => $entry[2]
                ];
            }
        }
        fclose($handler);
    }

    shuffle($entries);
    return $entries;
}

// End of loader.php
