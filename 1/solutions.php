<?php

// little function to log to terminal optionally based on a count
function info(string $message, int $count = null): void
{
    if ($count === null) {
        echo $message;
    } elseif ($count === 12) {
        echo $message;
    }
}

/*
 * --- Part One (Validated) ---
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
 * In this example, the calibration values of these four lines are 12, 38, 15, and 77. These summed produces 142.
 *
 * Consider your entire calibration document. What is the sum of all the calibration values?
 */

/*
$sum = 0;

$file_name = "puzzle-input.txt";
$file = fopen($file_name, "r");
if ($file) {
    while ($line = fgets($file)) {
        $first_number = null;
        $last_number = null;
        $final_number = null;

        foreach (str_split(trim($line)) as $character) {
            if (is_numeric($character)) {
                if ($first_number === null) {
                    $first_number = $character;
                } else {
                    $last_number = $character;
                }
            }
        }

        if ($first_number !== null and $last_number === null) {
            $final_number = (int)$first_number . $first_number;
        }

        if ($first_number !== null and $last_number !== null) {
            $final_number = (int)$first_number . $last_number;
        }

        $sum += $final_number;
    }
} else {
    echo 'Could not open file ' . $file_name . PHP_EOL;
}

// print final answer and save to clipboard to paste into answer input on the webpage
exec('echo "' . $sum . '" | pbcopy');
echo 'Answer: ' . $sum . PHP_EOL;
*/

/*
 * --- Part Two (Validated) ---
 * Your calculation isn't quite right. It looks like some of the digits are actually spelled out with letters: one, two,
 * three, four, five, six, seven, eight, and nine also count as valid "digits".
 *
 * Equipped with this new information, you now need to find the real first and last digit on each line. For example:
 *
 * two1nine
 * eightwothree
 * abcone2threexyz
 * xtwone3four
 * 4nineeightseven2
 * zoneight234
 * 7pqrstsixteen
 *
 * In this example, the calibration values are 29, 83, 13, 24, 42, 14, and 76. Adding these together produces 281.
 *
 * What is the sum of all the calibration values?
*/

$sum = 0;
$numbers_array = [
    'one' => 1
    , 'two' => 2
    , 'three' => 3
    , 'four' => 4
    , 'five' => 5
    , 'six' => 6
    , 'seven' => 7
    , 'eight' => 8
    , 'nine' => 9
];

$file_name = "puzzle-input.txt";
$file = fopen($file_name, "r");
if ($file) {
    while ($line = fgets($file)) {
        $first_number = null;
        $last_number = null;
        $final_number = null;
        $running_string = '';

        foreach (str_split(trim($line)) as $character) {
            $running_string .= $character;

            if (is_numeric($character)) {
                if ($first_number === null) {
                    $first_number = $character;
                } else {
                    $last_number = $character;
                }
                // if the character was a number we reset the string because character numbers are broken by integers
                $running_string = '';
            } else {
                // the shortest number is 3 characters
                // therefore only run the check if string is at least 3 characters long
                if (strlen($running_string) >= 3) {
                    foreach ($numbers_array as $written_number => $number) {
                        if (str_contains($running_string, $written_number)) {
                            if ($first_number === null) {
                                $first_number = $number;
                            } else {
                                $last_number = $number;
                            }

                            // if we found a written number, reset the running string to just the last letter to account
                            // for overlapping written numbers
                            $running_string = substr($running_string, -1);
                            break;
                        }
                    }
                }
            }
        } // END FOREACH

        if ($first_number !== null and $last_number === null) {
            $final_number = (int)$first_number . $first_number;
        }

        if ($first_number !== null and $last_number !== null) {
            $final_number = (int)$first_number . $last_number;
        }

        $sum += $final_number;
    }
} else {
    echo 'Could not open file ' . $file_name . PHP_EOL;
}

// print final answer and save to clipboard to paste into answer input on the webpage
exec('echo "' . $sum . '" | pbcopy');
echo 'Answer: ' . $sum . PHP_EOL;