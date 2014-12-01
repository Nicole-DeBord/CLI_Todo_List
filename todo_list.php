<?php

// Exercise 3.5.4. - updated todo list by adding functions

// Create array to hold list of todo items
$items = array();


function listItems($list) {
    
    // here we set $returnedItem to an empty string....
    $returnedItem = '';
    
    if (!(empty($list))) { 
        foreach($list as $key => $item) {

            // ... so that we can concantenate this onto it:
            $returnedItem .= "[{$key}] {$item} \n";
            $key++;
        }
            // 'return' is taken out of the foreach loop so it will
            // capture each iteration instead of ending after the 
            // first one
            return $returnedItem;

    // an added else statement provides functionality in the 
    // event that there is no input provided yet - this 
    // allows the user to know what's happening 
    } else {
        return 'No items' . PHP_EOL;
    }
        
}

// This function will get user input, and return that input.
// We can return it with or without changing to uppercase.
function getInput($upper = false) {

    // Capture user input, trim whitespace.
    $input = trim(fgets(STDIN));

    // If we passed in true when we called the function, 
    // change the input to uppercase.
    if ($upper == true) {
        // Overwrite the existing input with an uppercase version.
        $input = strtoupper($input);
    }

    // Return that input to main code.
    return $input;

    /*
        Remember we can call this function in two ways:
            1.  getInput(); -- will return input as entered.
            2.  getInput('Y') -- will return input uppercased.
    */
}



// The loop!
do {
    // Here I call my function and my array items get listed
    echo listItems($items);
    // Show the menu options
    echo '(N)ew item, (R)emove item, (Q)uit : ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = getInput(true);

    // Check for actionable input
    if ($input == 'N') {
        // Ask for entry
        echo 'Enter item: ';
        // Add entry to list array
        $items[] = getInput();
    } elseif ($input == 'R') {
        // Remove which item?
        echo 'Enter item number to remove: ';
        // Get array key
        // see how we added -1?
        $key = getInput();
        //Make sure remove still works after setting list to start at 1
        // Remove from array
        unset($items[$key]);
    }
// Exit when input is (Q)uit
} while ($input != 'Q');

// okay, I want to know why ^that business works - why && vs. || ?

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors
exit(0);