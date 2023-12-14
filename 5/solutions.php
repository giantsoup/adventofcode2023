<?php
// little function to log to terminal optionally based on a count
// clear file first
//file_put_contents('log.txt', '');
function info(string $message, int $info_count = 0, bool $log_to_file = false): void
{
    // Specify the log file path
    $logFilePath = 'log.txt';

    // Write the string representation of the array to the log file
    if ($info_count === 0) {
        if ($log_to_file) {
            file_put_contents($logFilePath, $message . PHP_EOL, FILE_APPEND);
        }
        echo $message . PHP_EOL;
    } elseif ($info_count === 1) {
        if ($log_to_file) {
            file_put_contents($logFilePath, $message . PHP_EOL, FILE_APPEND);
        }
        echo $message . PHP_EOL;
    }
}

/*
 * --- Part One ---
 *
 * The almanac (your puzzle input) lists all of the seeds that need to be planted. It also lists what type of soil to use with each kind of seed, what type of fertilizer to use with each kind of soil, what type of water to use with each kind of fertilizer, and so on. Every type of seed, soil, fertilizer and so on is identified with a number, but numbers are reused by each category - that is, soil 123 and fertilizer 123 aren't necessarily related to each other.
 *
 * For example:
 *
 * seeds: 79 14 55 13
 *
 * seed-to-soil map:
 * 50 98 2
 * 52 50 48
 *
 * soil-to-fertilizer map:
 * 0 15 37
 * 37 52 2
 * 39 0 15
 *
 * fertilizer-to-water map:
 * 49 53 8
 * 0 11 42
 * 42 0 7
 * 57 7 4
 *
 * water-to-light map:
 * 88 18 7
 * 18 25 70
 *
 * light-to-temperature map:
 * 45 77 23
 * 81 45 19
 * 68 64 13
 *
 * temperature-to-humidity map:
 * 0 69 1
 * 1 0 69
 *
 * humidity-to-location map:
 * 60 56 37
 * 56 93 4
 *
 * With this map, you can look up the soil number required for each initial seed number:
 * Seed number 79 corresponds to soil number 81.
 * Seed number 14 corresponds to soil number 14.
 * Seed number 55 corresponds to soil number 57.
 * Seed number 13 corresponds to soil number 13.
 *
 * The gardener and his team want to get started as soon as possible, so they'd like to know the closest location that
 * needs a seed. Using these maps, find the lowest location number that corresponds to any of the initial seeds. To do
 * this, you'll need to convert each seed number through other categories until you can find its corresponding location
 * number. In this example, the corresponding types are:
 *
 * Seed 79, soil 81, fertilizer 81, water 81, light 74, temperature 78, humidity 78, location 82.
 * Seed 14, soil 14, fertilizer 53, water 49, light 42, temperature 42, humidity 43, location 43.
 * Seed 55, soil 57, fertilizer 57, water 53, light 46, temperature 82, humidity 82, location 86.
 * Seed 13, soil 13, fertilizer 52, water 41, light 34, temperature 34, humidity 35, location 35.
 * So, the lowest location number in this example is 35.
 *
 * What is the lowest location number that corresponds to any of the initial seed numbers?
 */


$closest_location = 0;
$file_name = "puzzle-input-tester.txt";
$file = fopen($file_name, "r");
$mapping_array = [
    'seeds' => [],
    'seed-to-soil' => [],
    'soil-to-fertilizer' => [],
    'fertilizer-to-water' => [],
    'water-to-light' => [],
    'light-to-temperature' => [],
    'temperature-to-humidity' => [],
    'humidity-to-location' => [],
];
if ($file) {
    $current_destination = '';
    $row_count = 0;
    while ($line = fgets($file)) {
        $row_count++;

        if ($row_count === 1) {
            $seed_halves = explode(':', trim($line));
            $seeds = explode(' ', trim($seed_halves[1]));
            $mapping_array['seeds'] = $seeds;
            continue;
        }

        $row_pieces = explode(' ', trim($line));
        if ($row_pieces === ['']) {
            continue;
        }
        if ($row_pieces[1] === 'map:') {
            $current_destination = $row_pieces[0];
            continue;
        }
        $mapping_array[$current_destination][] = $row_pieces;
    }
} else {
    echo 'Could not open file ' . $file_name . PHP_EOL;
}
//info('Mapping array: ' . print_r($mapping_array, true));

$seed_array = array_shift($mapping_array);
foreach ($mapping_array as $map_chunk => $map_ranges) {
    foreach ($map_ranges as $map_range) {
        info('Map chunk: ' . $map_chunk . ' Map range: ' . print_r($map_range, true));
        $source_range = range($map_range[1], $map_range[1] + $map_range[2] - 1);
        info('Source range: ' . print_r($source_range, true));
        foreach ($seed_array as $seed) {
            // TODO: change this to check if the seed is between the range and then do (seed - source_start) + destination_start
            $seed_key = array_search($seed, $source_range);
            if ($seed_key !== false) {
                info('Found seed ' . $seed . ' in source range ' . print_r($source_range, true) . ' at key ' . $seed_key);
                $destination_range = range($map_range[0], $map_range[0] + $map_range[2] - 1);
                info('Destination range: ' . print_r($destination_range, true));
                $closest_location = $destination_range[$seed_key];
                info('Closest location: ' . $closest_location);
                die();
            }
        }
    }
}

// print final answer and save to clipboard to paste into answer input on the webpage
exec('echo "' . $closest_location . '" | pbcopy');
echo 'Answer: ' . $closest_location . PHP_EOL;


/*
 * --- Part Two ---
 *
 */

// print final answer and save to clipboard to paste into answer input on the webpage
//exec('echo "' . $closest_location . '" | pbcopy');
//echo 'Answer: ' . $closest_location . PHP_EOL;
