<?php

// exercise 3.4., part 1 - update the code to allow uppercase and 
// lowercase inputs from user - test add, remove, quit functionality

// Create array to hold list of todo items
$items = array();

// The loop!
do {
    // Iterate through list items
    foreach ($items as $key => $item) {
        // ***Start numbering list with 1 instead of 0
        $key++;
        // Display each item and a newline
        echo "[{$key}] {$item}\n";
    }

    // Show the menu options
    echo '(N)ew item, (R)emove item, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = trim(fgets(STDIN));

    // Check for actionable input
    if ($input == 'N' || $input =='n') {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $items[] = trim(fgets(STDIN));
    } elseif ($input == 'R' || $input == 'r') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        $key = trim(fgets(STDIN));
        // ***Make sure remove still works after setting list to start at 1
        $key--;
        // Remove from array
        unset($items[$key]);
    }
// Exit when input is (Q)uit
} while ($input != 'Q' && $input != 'q');

// okay, I want to know why ^that business works - why && vs. || ?

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);