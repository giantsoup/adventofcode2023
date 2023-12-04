<?php
// little function to log to terminal optionally based on a count
function info(string $message, int $count = 0): void
{
    if ($count === 0) {
        echo $message . PHP_EOL;
    } elseif ($count === 5) {
        echo $message . PHP_EOL;
    }
}

/*
 * --- Part One (Validated) ---
 * To get information, once a bag has been loaded with cubes, the Elf will reach into the bag, grab a handful of random
 * cubes, show them to you, and then put them back in the bag. He'll do this a few times per game.
 *
 * You play several games and record the information from each game (your puzzle input). Each game is listed with its ID
 * number (like the 11 in Game 11: ...) followed by a semicolon-separated list of subsets of cubes that were revealed
 * from the bag (like 3 red, 5 green, 4 blue).
 *
 * For example, the record of a few games might look like this:
 *
 * Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
 * Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue
 * Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red
 * Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red
 * Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green
 *
 * In game 1, three sets of cubes are revealed from the bag (and then put back again). The first set is 3 blue cubes and
 * 4 red cubes; the second set is 1 red cube, 2 green cubes, and 6 blue cubes; the third set is only 2 green cubes.
 *
 * The Elf would first like to know which games would have been possible if the bag contained only 12 red cubes, 13
 * green cubes, and 14 blue cubes?
 *
 * In the example above, games 1, 2, and 5 would have been possible if the bag had been loaded with that configuration.
 * However, game 3 would have been impossible because at one point the Elf showed you 20 red cubes at once; similarly,
 * game 4 would also have been impossible because the Elf showed you 15 blue cubes at once. If you add up the IDs of the
 * games that would have been possible, you get 8.
 *
 * Determine which games would have been possible if the bag had been loaded with only 12 red cubes, 13 green cubes, and
 * 14 blue cubes. What is the sum of the IDs of those games?
 */

/*
$sum = 0;
$file_name = "puzzle-input.txt";
$file = fopen($file_name, "r");
if ($file) {
    $count = 0;
    while ($line = fgets($file)) {
        $count++;
        $game_id_and_cubes = explode(':', $line);
        $game_id_string = trim($game_id_and_cubes[0]);

        foreach (explode(';', trim($game_id_and_cubes[1])) as $round) {
            foreach (explode(',', trim($round)) as $cube) {
                $cube_array = explode(' ', trim($cube));
                if ($cube_array[1] === 'red' and (int)$cube_array[0] > 12) {
                    continue 3;
                }
                if ($cube_array[1] === 'green' and (int)$cube_array[0] > 13) {
                    continue 3;
                }
                if ($cube_array[1] === 'blue' and (int)$cube_array[0] > 14) {
                    continue 3;
                }
            }
        }

        // if we don't continue to next game then that means this game is valid
        // therefore we add the game id to the sum
        $sum += (int)explode(' ', $game_id_string)[1];

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
 * As you continue your walk, the Elf poses a second question: in each game you played, what is the fewest number of
 * cubes of each color that could have been in the bag to make the game possible?
 *
 * Again consider the example games from earlier:
 *
 * Game 1: 3 blue, 4 red; 1 red, 2 green, 6 blue; 2 green
 * Game 2: 1 blue, 2 green; 3 green, 4 blue, 1 red; 1 green, 1 blue
 * Game 3: 8 green, 6 blue, 20 red; 5 blue, 4 red, 13 green; 5 green, 1 red
 * Game 4: 1 green, 3 red, 6 blue; 3 green, 6 red; 3 green, 15 blue, 14 red
 * Game 5: 6 red, 1 blue, 3 green; 2 blue, 1 red, 2 green
 *
 * In game 1, the game could have been played with as few as 4 red, 2 green, and 6 blue cubes. If any color had even one
 * fewer cube, the game would have been impossible.
 * Game 2 could have been played with a minimum of 1 red, 3 green, and 4 blue cubes.
 * Game 3 must have been played with at least 20 red, 13 green, and 6 blue cubes.
 * Game 4 required at least 14 red, 3 green, and 15 blue cubes.
 * Game 5 needed no fewer than 6 red, 3 green, and 2 blue cubes in the bag.
 *
 * The power of a set of cubes is equal to the numbers of red, green, and blue cubes multiplied together. The power of
 * the minimum set of cubes in game 1 is 48. In games 2-5 it was 12, 1560, 630, and 36, respectively. Adding up these
 * five powers produces the sum 2286.
 *
 * For each game, find the minimum set of cubes that must have been present. What is the sum of the power of these sets?
 */

$sum = 0;
$file_name = "puzzle-input.txt";
$file = fopen($file_name, "r");
if ($file) {
    $count = 0;
    while ($line = fgets($file)) {
        $count++;
        $game_id_and_cubes = explode(':', $line);
        $game_id_string = trim($game_id_and_cubes[0]);

        $most_red = 0;
        $most_green = 0;
        $most_blue = 0;

        foreach (explode(';', trim($game_id_and_cubes[1])) as $round) {
            foreach (explode(',', trim($round)) as $cube) {
                $cube_array = explode(' ', trim($cube));
                $cube_name = $cube_array[1];
                $cube_number = (int)$cube_array[0];
                if ($cube_name === 'red') {
                    if ($cube_number > $most_red) {
                        $most_red = $cube_number;
                    }
                }
                if ($cube_name === 'green') {
                    if ($cube_number > $most_green) {
                        $most_green = $cube_number;
                    }
                }
                if ($cube_name === 'blue') {
                    if ($cube_number > $most_blue) {
                        $most_blue = $cube_number;
                    }
                }
            }
        }

        // if we don't continue to next game then that means this game is valid
        // therefore we add the game id to the sum
        $sum += ($most_red * $most_green * $most_blue);

    }
} else {
    echo 'Could not open file ' . $file_name . PHP_EOL;
}

// print final answer and save to clipboard to paste into answer input on the webpage
exec('echo "' . $sum . '" | pbcopy');
echo 'Answer: ' . $sum . PHP_EOL;