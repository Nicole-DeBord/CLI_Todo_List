<?php

// below are some alternative methods to solve exercise 3.4.

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
    // this is a much easier way to accept upper and lowercase items
    $input = strtoupper($input);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $items[] = trim(fgets(STDIN));
    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        // see how we added -1?
        $key = trim(fgets(STDIN)) -1;
        //Make sure remove still works after setting list to start at 1
        // Remove from array
        unset($items[$key]);

        // Here we overwrite $items with 
        $items = array_values($items);
    }
// Exit when input is (Q)uit
} while ($input != 'Q' && $input != 'q');

// okay, I want to know why ^that business works - why && vs. || ?

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);