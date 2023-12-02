<?php

/*
 * The newly-improved calibration document consists of lines of text; each line originally contained a specific
 * calibration value that the Elves now need to recover. On each line, the calibration value can be found by combining
 * the first digit and the last digit (in that order) to form a single two-digit number.
 *
 * For example:
 * 1abc2
 * pqr3stu8vwx
 * a1b2c3d4e5f
 * treb7uchet
 *
 * In this example, the calibration values of these four lines are 12, 38, 15, and 77. Adding these together produces 142.
 *
 * Consider your entire calibration document. What is the sum of all of the calibration values?
 */

$sum = 0;
$lines = file('puzzle-input.txt');
foreach ($lines as $line) {
    $sum += (int) $line[0] + (int) $line[strlen($line) - 2];
}

// print final answer and save to clipboard to paste into answer input on the webpage
exec('echo "'.$sum.'" | pbcopy');
echo 'Answer: '.$sum.PHP_EOL;