<?php
// little function to log to terminal optionally based on a count
// clear file first
file_put_contents('log.txt', '');
function info(string $message, int $info_count = 0): void
{
    // Specify the log file path
    $logFilePath = 'log.txt';

    // Write the string representation of the array to the log file
    if ($info_count === 0) {
        file_put_contents($logFilePath, $message . PHP_EOL, FILE_APPEND);
        echo $message . PHP_EOL;
    } elseif ($info_count === 2) {
        file_put_contents($logFilePath, $message . PHP_EOL, FILE_APPEND);
        echo $message . PHP_EOL;
    }
}

/*
 * --- Part One (Validated)---
 * The engineer explains that an engine part seems to be missing from the engine, but nobody can figure out which one.
 * If you can add up all the part numbers in the engine schematic, it should be easy to work out which part is missing.
 * The engine schematic (your puzzle input) consists of a visual representation of the engine. There are lots of numbers
 * and symbols you don't really understand, but apparently any number adjacent to a symbol, even diagonally, is a
 * "part number" and should be included in your sum. (Periods (.) do not count as a symbol.)
 *
 * Here is an example engine schematic:
 *
 * 467..114..
 * ...*......
 * ..35..633.
 * ......#...
 * 617*......
 * .....+.58.
 * ..592.....
 * ......755.
 * ...$.*....
 * .664.598..
 *
 * In this schematic, two numbers are not part numbers because they are not adjacent to a symbol: 114 (top right) and 58
 * (middle right). Every other number is adjacent to a symbol and so is a part number; their sum is 4361.
 *
 * Of course, the actual engine schematic is much larger. What is the sum of all the part numbers in the engine
 * schematic?
 */

/*
// example of expected data in mapping
$schematic_mapping = [
    1 => [
        'numbers' => [
             [416,1,2,3],
             [559,29,30,31],
             [417,47,48,49],
        ],
        'symbols' => []
    ],
    2 => [
        'numbers' => [
             [702,10,11,12],
             [772,18,19,20],
             [378,33,34,35],
        ],
        'symbols' => [13,50,64,79]
    ],
];
*/

$schematic_mapping = [];

$file_name = "puzzle-input.txt";
$file = fopen($file_name, "r");
if ($file) {
    $row_count = 0;
    while ($line = fgets($file)) {
        $row_count++;
        // create empty array for this row
        $schematic_mapping[$row_count] = [
            'numbers' => [],
            'symbols' => [],
        ];

        $character_count = 0;
        $current_number = null;
        $full_line_array = str_split(trim($line));
        // handle the row
        foreach ($full_line_array as $character) {
            $character_count++;
            if ($character === '.') {
                if ($current_number !== null) {
                    // have to save the current number to the current row
                    $schematic_mapping[$row_count]['numbers'][] = array_merge([implode('', $current_number['numbers'])], $current_number['positions']);
                    $current_number = null;
                }
            } elseif (!is_numeric($character)) {
                if ($current_number !== null) {
                    // have to save the current number to the current row
                    $schematic_mapping[$row_count]['numbers'][] = array_merge([implode('', $current_number['numbers'])], $current_number['positions']);
                    $current_number = null;
                }
                $schematic_mapping[$row_count]['symbols'][] = [$character, $character_count];
            } else {
                // if it's a number do this
                $current_number['numbers'][] = $character;
                $current_number['positions'][] = $character_count;
                if ($character_count === count($full_line_array) and $current_number !== null) {
                    // have to save the current number to the current row
                    $schematic_mapping[$row_count]['numbers'][] = array_merge([implode('', $current_number['numbers'])], $current_number['positions']);
                    $current_number = null;
                }
            }
        }
    }
} else {
    echo 'Could not open file ' . $file_name . PHP_EOL;
}

/*
$sum = 0;
// loop over $schematic_mapping
for ($i = 1; $i <= count($schematic_mapping); $i++) {
    // loop over each number in the row to check for touching symbols
    foreach ($schematic_mapping[$i]['numbers'] as $number_and_positions) {
        $number = array_shift($number_and_positions);
        $positions = $number_and_positions;
        info('checking number ' . $number . ' in row ' . $i . ': ', $i);
        $adjacent_positions = [];
        $left_adjacent = $positions[0] - 1;
        if ($left_adjacent > 0) {
            $adjacent_positions[] = $left_adjacent;
        }
        $adjacent_positions[] = end($positions) + 1;
        info('adjacent_positions: ' . implode(', ', $adjacent_positions), $i);
        // check adjacent positions in same row
        if (count($schematic_mapping[$i]['symbols'])) {
            info('checking adjacent in same row', $i);
            info('same row symbols: ' . implode(', ', $schematic_mapping[$i]['symbols']), $i);
            // if we have intersecting values then the number is touching an adjacent symbol in the same row
            if (count(array_intersect($adjacent_positions, $schematic_mapping[$i]['symbols']))) {
                info('found adjacent in same row, adding...', $i);
                $sum += $number;
                info('Sum after ' . $number . ' in row ' . $i . ': ' . $sum . PHP_EOL, $i);
                continue;
            }
        }

        // add adjacent positions to number positions to check for diagonals in rows above and below
        $all_positions = array_merge($positions, $adjacent_positions);
        info('all_positions: ' . implode(', ', $all_positions), $i);
        // check positions in row above
        if ($i > 1 and count($schematic_mapping[$i - 1]['symbols'])) {
            info('checking positions in above row', $i);
            info('above row symbols: ' . implode(', ', $schematic_mapping[$i - 1]['symbols']), $i);
            // if we have intersecting values then the number is touching an adjacent symbol in the same row
            if (count(array_intersect($all_positions, $schematic_mapping[$i - 1]['symbols']))) {
                info('found position in above row, adding...', $i);
                $sum += $number;
                info('Sum after ' . $number . ' in row ' . $i . ': ' . $sum . PHP_EOL, $i);
                continue;
            }
        }

        // check adjacent positions in row below
        if ($i < count($schematic_mapping) and count($schematic_mapping[$i + 1]['symbols'])) {
            info('checking positions in below row', $i);
            info('below row symbols: ' . implode(', ', $schematic_mapping[$i + 1]['symbols']), $i);
            // if we have intersecting values then the number is touching an adjacent symbol in the same row
            if (count(array_intersect($all_positions, $schematic_mapping[$i + 1]['symbols']))) {
                info('found position in below row, adding...', $i);
                $sum += $number;
                info('Sum after ' . $number . ' in row ' . $i . ': ' . $sum . PHP_EOL, $i);
                continue;
            }
        }
        info('No match for ' . $number . ' in row ' . $i . ': ' . PHP_EOL, $i);
    }

}
*/
// print final answer and save to clipboard to paste into answer input on the webpage
//exec('echo "' . $sum . '" | pbcopy');
//echo 'Answer: ' . $sum . PHP_EOL;


/*
 * --- Part Two (Validated) ---
 *
 * The missing part wasn't the only issue - one of the gears in the engine is wrong. A gear is any * symbol that is
 * adjacent to exactly two part numbers. Its gear ratio is the result of multiplying those two numbers together.
 *
 * This time, you need to find the gear ratio of every gear and add them all up so that the engineer can figure out
 * which gear needs to be replaced.
 *
 * Consider the same engine schematic again:
 *
 * 467..114..
 * ...*......
 * ..35..633.
 * ......#...
 * 617*......
 * .....+.58.
 * ..592.....
 * ......755.
 * ...$.*....
 * .664.598..
 *
 * In this schematic, there are two gears. The first is in the top left; it has part numbers 467 and 35, so its gear
 * ratio is 16345. The second gear is in the lower right; its gear ratio is 451490. (The * adjacent to 617 is not a gear
 * because it is only adjacent to one part number.) Adding up all the gear ratios produces 467835.
 *
 * What is the sum of all the gear ratios in your engine schematic?
 */


$sum = 0;
// loop over $schematic_mapping
$sum_loop_count = 0;
for ($i = 1; $i <= count($schematic_mapping); $i++) {
    $sum_loop_count++;
    // loop over each number in the row to check for touching symbols
    foreach ($schematic_mapping[$i]['symbols'] as $symbol_and_position) {
        $gear_ratio_numbers =[];
        $symbol = array_shift($symbol_and_position);
        $position = $symbol_and_position[0];
        $all_positions = [$position - 1, $position, $position + 1];

        if ($symbol === '*') {
            // check row above
            if ($i > 1 and count($schematic_mapping[$i - 1]['numbers'])) {
                foreach ($schematic_mapping[$i - 1]['numbers'] as $number_and_position) {
                    $number = array_shift($number_and_position);
                    $number_positions = $number_and_position;
                    if (count(array_intersect($all_positions, $number_positions))) {
                        $gear_ratio_numbers[] = $number;
                    }
                }
            }
            // check adjacent
            if (count($schematic_mapping[$i]['numbers'])) {
                foreach ($schematic_mapping[$i]['numbers'] as $number_and_position) {
                    $number = array_shift($number_and_position);
                    $number_positions = $number_and_position;
                    if (count(array_intersect($all_positions, $number_positions))) {
                        $gear_ratio_numbers[] = $number;
                    }
                }
            }
            // check below
            if ($i < count($schematic_mapping) and count($schematic_mapping[$i + 1]['numbers'])) {
                foreach ($schematic_mapping[$i + 1]['numbers'] as $number_and_position) {
                    $number = array_shift($number_and_position);
                    $number_positions = $number_and_position;
                    if (count(array_intersect($all_positions, $number_positions))) {
                        $gear_ratio_numbers[] = $number;
                    }
                }
            }

            // incase we find more than one number adjacent to a *, only multiply the first two numbers found
            if (!empty($gear_ratio_numbers[0]) and !empty($gear_ratio_numbers[1])) {
                $sum += $gear_ratio_numbers[0] * $gear_ratio_numbers[1];
            }
        }
    }

}

// print final answer and save to clipboard to paste into answer input on the webpage
exec('echo "' . $sum . '" | pbcopy');
echo 'Answer: ' . $sum . PHP_EOL;
