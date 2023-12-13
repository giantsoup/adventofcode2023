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
 * As far as the Elf has been able to figure out, you have to figure out which of the numbers you have that appear in
 * the list of winning numbers. The first match makes the card worth one point and each match after the first doubles
 * the point value of that card.
 *
 * For example:
 * Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
 * Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19
 * Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1
 * Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83
 * Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36
 * Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11
 *
 * In the above example, card 1 has five winning numbers (41, 48, 83, 86, and 17) and eight numbers you have
 * (83, 86, 6, 31, 17, 9, 48, and 53). Of the numbers you have, four of them (48, 83, 17, and 86) are winning numbers!
 * That means card 1 is worth 8 points (1 for the first match, then doubled three times for each of the three matches
 * after the first).
 *
 * Card 2 has two winning numbers (32 and 61), so it is worth 2 points.
 * Card 3 has two winning numbers (1 and 21), so it is worth 2 points.
 * Card 4 has one winning number (84), so it is worth 1 point.
 * Card 5 has no winning numbers, so it is worth no points.
 * Card 6 has no winning numbers, so it is worth no points.
 *
 * So, in this example, the Elf's pile of scratchcards is worth 13 points.
 *
 * Take a seat in the large pile of colorful cards. How many points are they worth in total?
 */

/*
$sum = 0;
$file_name = "puzzle-input.txt";
$file = fopen($file_name, "r");
if ($file) {
    $row_count = 0;
    while ($line = fgets($file)) {
        $row_count++;

        $card_main_parts = explode(':', trim($line));
        $card_name = $card_main_parts[0];
        $clean_card_halves = preg_replace('/\s+/', ' ', trim($card_main_parts[1]));
        $winners_and_my_numbers = explode('|', $clean_card_halves);
        $winning_numbers = explode(' ', trim($winners_and_my_numbers[0]));
        $my_numbers = explode(' ', trim($winners_and_my_numbers[1]));
        // find and return all matching elements from $winning_numbers that exist in $my_numbers
        $matching_numbers = array_intersect($winning_numbers, $my_numbers);
        $value = 0;
        if (count($matching_numbers) > 1) {
            // need to remove one element so the doubling works properly
            // array_reduce takes a value to start with, so we set that to 1 and just remove one element from the array
            array_shift($matching_numbers);
            $value = array_reduce($matching_numbers, function ($carry, $element) use ($row_count) {
                return $carry * 2;
            }, 1);
        } elseif (count($matching_numbers) === 1) {
            $value = 1;
        }

        $sum += $value;
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
 * Just as you're about to report your findings to the Elf, one of you realizes that the rules have actually been
 * printed on the back of every card this whole time.
 *
 * There's no such thing as "points". Instead, scratchcards only cause you to win more scratchcards equal to the number
 * of winning numbers you have.
 *
 * Specifically, you win copies of the scratchcards below the winning card equal to the number of matches. So, if card
 * 10 were to have 5 matching numbers, you would win one copy each of cards 11, 12, 13, 14, and 15.
 *
 * Copies of scratchcards are scored like normal scratchcards and have the same card number as the card they copied. So,
 * if you win a copy of card 10, and it has 5 matching numbers, it would then win a copy of the same cards that the
 * original card 10 won: cards 11, 12, 13, 14, and 15. This process repeats until none of the copies cause you to win
 * any more cards. (Cards will never make you copy a card past the end of the table.)
 *
 * This time, the above example goes differently:
 *
 * Card 1: 41 48 83 86 17 | 83 86  6 31 17  9 48 53
 * Card 2: 13 32 20 16 61 | 61 30 68 82 17 32 24 19
 * Card 3:  1 21 53 59 44 | 69 82 63 72 16 21 14  1
 * Card 4: 41 92 73 84 69 | 59 84 76 51 58  5 54 83
 * Card 5: 87 83 26 28 32 | 88 30 70 12 93 22 82 36
 * Card 6: 31 18 13 56 72 | 74 77 10 23 35 67 36 11
 *
 * Card 1 has four matching numbers, so you win one copy each of the next four cards: cards 2, 3, 4, and 5.
 * Your original card 2 has two matching numbers, so you win one copy each of cards 3 and 4.
 * Your copy of card 2 also wins one copy each of cards 3 and 4.
 * Your four instances of card 3 (one original and three copies) have two matching numbers, so you win four copies each
 * of cards 4 and 5.
 * Your eight instances of card 4 (one original and seven copies) have one matching number, so you win eight copies of
 * card 5.
 * Your fourteen instances of card 5 (one original and thirteen copies) have no matching numbers and win no more cards.
 * Your one instance of card 6 (one original) has no matching numbers and wins no more cards.
 * Once all the originals and copies have been processed, you end up with 1 instance of card 1, 2 instances of card 2,
 * 4 instances of card 3, 8 instances of card 4, 14 instances of card 5, and 1 instance of card 6. In total, this
 * example pile of scratchcards causes you to ultimately have 30 scratchcards!
 *
 * Process all the original and copied scratchcards until no more scratchcards are won. Including the original set of
 * scratchcards, how many total scratchcards do you end up with?
 *
 * $copies_array = [
 *     1 => 0,
 *     2 => 1,
 *     3 => 3,
 *     4 => 7,
 *     5 => 13,
 * ];
 */

$file_name = "puzzle-input.txt";
$file = fopen($file_name, "r");
$copies_array = [];
$row_count = 0;
if ($file) {
    while ($line = fgets($file)) {
        $row_count++;

        $card_main_parts = explode(':', trim($line));
        $card_name = $card_main_parts[0];
        $clean_card_halves = preg_replace('/\s+/', ' ', trim($card_main_parts[1]));
        $winners_and_my_numbers = explode('|', $clean_card_halves);
        $winning_numbers = explode(' ', trim($winners_and_my_numbers[0]));
        $my_numbers = explode(' ', trim($winners_and_my_numbers[1]));
        // find and return all matching elements from $winning_numbers that exist in $my_numbers
        $matching_numbers = array_intersect($winning_numbers, $my_numbers);

        if (!isset($copies_array[$row_count])) {
            $copies_array[$row_count] = 0;
        }

        // foreach copy plus the original, handle copying the cards
        $copies_plus_original_count = $copies_array[$row_count] + 1;
        for ($c = 1; $c <= $copies_plus_original_count; $c++) {
            // foreach matching number walk down the $copies array and add additional copies
            $matches_count = count($matching_numbers);
            for ($i = 1; $i <= $matches_count; $i++) {
                $copied_line = $row_count + $i;
                if (isset($copies_array[$copied_line])) {
                    $copies_array[$copied_line]++;
                } else {
                    $copies_array[$copied_line] = 1;
                }
            }
        }
    }
} else {
    echo 'Could not open file ' . $file_name . PHP_EOL;
}

// add up all the copies and the row count to get the total scratchcards
$total_copies = 0;
foreach ($copies_array as $row_copies) {
    $total_copies += $row_copies;
}

$sum = $row_count + $total_copies;

// print final answer and save to clipboard to paste into answer input on the webpage
exec('echo "' . $sum . '" | pbcopy');
echo 'Answer: ' . $sum . PHP_EOL;
