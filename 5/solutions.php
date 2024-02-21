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
 * --- Part One (Validated) ---
 *
 * The almanac (your puzzle input) lists all the seeds that need to be planted. It also lists what type of soil to
 * use with each kind of seed, what type of fertilizer to use with each kind of soil, what type of water to use with
 * each kind of fertilizer, and so on. Every type of seed, soil, fertilizer and so on is identified with a number, but
 * numbers are reused by each category - that is, soil 123 and fertilizer 123 aren't necessarily related to each other.
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


//$closest_location = 0;
//$file_name = "puzzle-input-tester.txt";
//$file = fopen($file_name, "r");
//$mapping_array = [
//    'seeds' => [],
//    'seed-to-soil' => [],
//    'soil-to-fertilizer' => [],
//    'fertilizer-to-water' => [],
//    'water-to-light' => [],
//    'light-to-temperature' => [],
//    'temperature-to-humidity' => [],
//    'humidity-to-location' => [],
//];
//if ($file) {
//    $current_destination = '';
//    $row_count = 0;
//    while ($line = fgets($file)) {
//        $row_count++;
//
//        if ($row_count === 1) {
//            $seed_halves = explode(':', trim($line));
//            $seeds = explode(' ', trim($seed_halves[1]));
//            $mapping_array['seeds'] = array_map(fn($item) => ['original-seed' => $item, 'seed' => $item, 'found' => false], $seeds);
//            continue;
//        }
//
//        $row_pieces = explode(' ', trim($line));
//        if ($row_pieces === ['']) {
//            continue;
//        }
//        if ($row_pieces[1] === 'map:') {
//            $current_destination = $row_pieces[0];
//            continue;
//        }
//        $mapping_array[$current_destination][] = $row_pieces;
//    }
//} else {
//    echo 'Could not open file ' . $file_name . PHP_EOL;
//}
//fclose($file);
//
//info('Mapping array: ' . print_r($mapping_array, true));
//die();
//$seeds_array = array_shift($mapping_array);
//foreach ($mapping_array as $map_chunk => $map_ranges) {
//    foreach ($map_ranges as $map_range) {
////        info('Map chunk: ' . $map_chunk . ' Map range: ' . print_r($map_range, true));
//        foreach ($seeds_array as &$seed_array) {
//            if ($seed_array['found']) {
//                continue;
//            }
//            if ($seed_array['seed'] >= $map_range[1] && $seed_array['seed'] <= $map_range[1] + $map_range[2] - 1) {
//                $new_seed = ($seed_array['seed'] - $map_range[1]) + $map_range[0];
//                $seed_array['seed'] = $new_seed;
//                $seed_array['found'] = true;
////                info('Destination Seed Found: ' . print_r($seed_array, true));
//            }
//        }
//    }
////    info('Seeds: ' . print_r($seeds_array, true));
//    // after processing the whole chunk reset the seeds to not found
//    foreach ($seeds_array as &$seed_stuff) {
//        $seed_stuff['found'] = false;
//    }
//}
////info('Final Seeds: ' . print_r($seeds_array, true));
//$final_seeds = array_column($seeds_array, 'seed');
//$closest_location = min($final_seeds);
// print final answer and save to clipboard to paste into answer input on the webpage
//exec('echo "' . $closest_location . '" | pbcopy');
//echo 'Answer: ' . $closest_location . PHP_EOL;

/*
 * --- Part Two ---
 *
 * Everyone will starve if you only plant such a small number of seeds. Re-reading the almanac, it looks like the seeds:
 * line actually describes ranges of seed numbers.
 * The values on the initial seeds: line come in pairs. Within each pair, the first value is the start of the range and
 * the second value is the length of the range. So, in the first line of the example above:
 *
 * seeds: 79 14 55 13
 * This line describes two ranges of seed numbers to be planted in the garden. The first range starts with seed number
 * 79 and contains 14 values: 79, 80, ..., 91, 92. The second range starts with seed number 55 and contains 13 values:
 * 55, 56, ..., 66, 67.
 *
 * Now, rather than considering four seed numbers, you need to consider a total of 27 seed numbers.
 *
 * In the above example, the lowest location number can be obtained from seed number 82, which corresponds to soil 84,
 * fertilizer 84, water 84, light 77, temperature 45, humidity 46, and location 46. So, the lowest location number is 46.
 * Consider all the initial seed numbers listed in the ranges on the first line of the almanac. What is the lowest
 * location number that corresponds to any of the initial seed numbers?
 *
 * compare seed range to destination range and use the offset to modify the start-end of the seed range
 *
 *
 *
 */

$closest_location = 0;
$file_name = "puzzle-input.txt";
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
            $seed_pairs = array_chunk($seeds, 2);
            $mapping_array['seeds'] = array_map(fn($item) => [
                'original-seed' => $item[0]
                , 'seed-start' => $item[0]
                , 'seed-end' => ($item[0] + $item[1]) - 1
                , 'found' => false
            ], $seed_pairs);

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
fclose($file);

//info('Mapping array: ' . print_r($mapping_array, true));
$seeds_array = array_shift($mapping_array);
//info('Seeds array: ' . print_r($seeds_array, true));
//info('Seeds array count start: ' . count($seeds_array));
//die();
foreach ($mapping_array as $map_chunk => $map_ranges) {
    foreach ($map_ranges as $map_range) {
//        info('Map chunk: ' . $map_chunk . ' Map range: ' . print_r($map_range, true));
        foreach ($seeds_array as &$seed_array) {
            if ($seed_array['found']) {
                continue;
            }

            // if the seed range is contained in the source range
            if ($seed_array['seed-start'] >= $map_range[1]
                && $seed_array['seed-end'] <= ($map_range[1] + $map_range[2]) - 1) {
//                info('Starting Seed array: ' . print_r($seed_array, true));
                $new_seed_start = ($seed_array['seed-start'] - $map_range[1]) + $map_range[0];
                $new_seed_end = ($seed_array['seed-end'] - $seed_array['seed-start']) + $new_seed_start;
                $seed_array['seed-start'] = $new_seed_start;
                $seed_array['seed-end'] = $new_seed_end;
                $seed_array['found'] = true;
//                info('Destination Seeds Found For Entire Range: ' . print_r($seed_array, true));
                continue;
            }

            // if the seed range starts in the source range but ends outside of it
            if ($seed_array['seed-start'] >= $map_range[1]
                && $seed_array['seed-start'] <= ($map_range[1] + $map_range[2]) - 1
                && $seed_array['seed-end'] > ($map_range[1] + $map_range[2]) - 1) {
//                info('Starting Seed array: ' . print_r($seed_array, true));
                $new_seed_start = ($seed_array['seed-start'] - $map_range[1]) + $map_range[0];
                $new_seed_end = ($map_range[2] - $seed_array['seed-start']) + $new_seed_start;

                // before overwriting seed values, create a new seed range with the leftovers
                $new_range_seed_start = $map_range[2] + 1;
                $new_range_seed_end = $seed_array['seed-end'];
                // add a new seed to the $seeds_array and set it to found so that we don't try to process it again
                $new_seed_range = [
                    'original-seed' => $seed_array['original-seed']
                    , 'seed-start' => $new_range_seed_start
                    , 'seed-end' => $new_range_seed_end
                    , 'found' => true
                ];
                if ($map_chunk === 'humidity-to-location') {
                    $new_seed_range['exclude'] = true;
                }

                $seeds_array[] = $new_seed_range;
//                info('New Range Seed For End of Range: ' . print_r($new_seed_range, true));

                // now we can reset this seed to the new values
                $seed_array['seed-start'] = $new_seed_start;
                $seed_array['seed-end'] = $new_seed_end;
                $seed_array['found'] = true;
//                info('Destination Seed Found For Beginning of Range: ' . print_r($seed_array, true));
                continue;
            }

            // if the seed range ends in the source range but starts outside of it
            if ($seed_array['seed-start'] < $map_range[1]
                && $seed_array['seed-end'] >= $map_range[1]
                && $seed_array['seed-end'] <= ($map_range[1] + $map_range[2]) - 1) {
//                info('Starting Seed array: ' . print_r($seed_array, true));
                $new_seed_start = $map_range[0];
                $new_seed_end = ($seed_array['seed-end'] - $map_range[1]) + $new_seed_start;
                // 79, 80, 81, 82, 83, 84
                //         81, 82, 83, 84, 85, 86
                //          0,  1,  2,  3,  4,  5

                // before overwriting seed values, create a new seed range with the leftovers
                $new_range_seed_start = $seed_array['seed-start'];
                $new_range_seed_end = $map_range[1] - 1;
                // add a new seed to the $seeds_array and set it to found so that we don't try to process it again
                $new_seed_range = [
                    'original-seed' => $seed_array['original-seed']
                    , 'seed-start' => $new_range_seed_start
                    , 'seed-end' => $new_range_seed_end
                    , 'found' => true
                ];
                if ($map_chunk === 'humidity-to-location') {
                    $new_seed_range['exclude'] = true;
                }
                $seeds_array[] = $new_seed_range;
//                info('New Range Seed For Beginning of Range: ' . print_r($new_seed_range, true));

                // now we can reset this seed to the new values
                $seed_array['seed-start'] = $new_seed_start;
                $seed_array['seed-end'] = $new_seed_end;
                $seed_array['found'] = true;
//                info('Destination Seed Found For End of Range: ' . print_r($seed_array, true));
            }
        }
    }
    if ($map_chunk === 'soil-to-fertilizer') {
//        info('Seeds: ' . print_r($seeds_array, true));
//        info('Seeds array count end: ' . count($seeds_array));
//        die();
    }
    // after processing the whole chunk reset the seeds to not found
    foreach ($seeds_array as &$seed_stuff) {
        $seed_stuff['found'] = false;
    }

}
//info('Final Seeds: ' . print_r($seeds_array, true));
//info('Final Seeds Count: ' . count($seeds_array));
//die();
// map filter the seeds, for all the seeds that have found as true, get the lowest value for the column seed-start
$final_seeds = array_filter($seeds_array, function ($seed) {
    return !isset($seed['exclude']);
});
info('Final Seeds: ' . print_r($final_seeds, true));

$closest_location = min(array_column($final_seeds, 'seed-start'));


// print final answer and save to clipboard to paste into answer input on the webpage
exec('echo "' . $closest_location . '" | pbcopy');
echo 'Answer: ' . $closest_location . PHP_EOL;