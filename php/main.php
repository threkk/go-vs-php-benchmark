<?php 

require_once('./php/loader.php');

const CORPUS = './corpus';
const X = './corpus-x';

ini_set('memory_limit', '-1');

echo '=> Importing datasets.'.PHP_EOL;
$corpus = loadCorpus(CORPUS);
$xs = loadX(X);


echo '=> Placing the elements in the intermediate table.'.PHP_EOL;
$startSort = microtime(true);

// Set up the table in which we will place the values.
$table = [];
foreach ($xs as $x) {
    // Initialise the arrays.
    $table[$x] = [];
}

// Starting the placement.
foreach ($corpus as $element) {
    if (!isset($element['x'], $element['y'], $element['value'])) {
        echo '=> Critic algorithm failure.'.PHP_EOL;
        exit(1);
    }

    $x = $element['x'];
    $y = $element['y'];
    $value = $element['value'];
    $table[$x][$y] = $value;
}

// Ordering the entries. Currently they are grouped so they can be safely
// ordered.
ksort($table);
foreach ($table as $key => $row) {
    ksort($table[$key]);
}

$endSort = microtime(true);
echo '=> Sorting finished!'.PHP_EOL;


echo '=> Starting transpose of the table to its final form.'.PHP_EOL;
$output = [];

$startTrans = microtime(true);
// We add the x rows first.
$output[0] = $xs;

foreach ($table as $x => $yvalue) {
    foreach ($yvalue as $y => $value) {
        $xIndex = array_search($x, $xs);
        $output[$y + 1][$xIndex] = $value; 
    }
}


echo '=> Transpose finished!'.PHP_EOL;
$endTrans = microtime(true);


echo '=> Ensuring the validity of the table'.PHP_EOL;
// Remove the header.
$trans = $output; 
$header = array_shift($trans);
if ($header !== $xs) {
    echo '=> Transpose error: header => '.$header.' xs => '.$xs;
}

foreach($trans as $yIndex => $values) {
    foreach ($values as $xIndex => $v) {
        $x = $xs[$xIndex];

        $value = $table[$x][$yIndex];
        $computedValue = 'x='.$x.',y='.$yIndex;
        if ($value !== $computedValue) {
            echo '=> Transpose error: value => '.$value.' computedValue => '.$computedValue.PHP_EOL; 
        }
    }
}

$diff = $endTrans - $startSort;
$diffSort = $endSort - $startSort;
$diffTrans = $endTrans - $startTrans;
echo PHP_EOL;
echo 'Total execution time: '.$diff.PHP_EOL;
echo 'Sorting execution time: '.$diffSort.PHP_EOL;
echo 'Transpose execution time: '.$diffTrans.PHP_EOL;
// End of main.php
