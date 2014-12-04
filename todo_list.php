<?php

// Exercise 3.7.1. - Added a s(A)ve option; created a function that opens, writes todo items to, 
// and saves a file

// This array will hold todo items entered by the user.
$items = array();


// This function returns items entered into the array as default indexed key => value list.
// Key numbers and their values are concatenated onto an empty string so they can be echoed.
// The key is incremented to avoid an infinite loop.
// Our data is returned outside of the foreach loop so it will be returned after ALL iterations.
// If $list is empty, 'no items' is returned so the users knows new items must be added.
function listItems($list) {
    $returnedItem = '';
    if (!(empty($list))) { 
        foreach($list as $key => $item) {
            $returnedItem .= "[{$key}] {$item} \n";
            $key++;
        }
        return $returnedItem;
    } else {
        return 'No items.' . PHP_EOL;
    }
}

// This function will get user input, and return that input.
// We can return it with or without changing to uppercase.
function getInput($upper = false) {

// There are a few ways to do this - 
// option 1:

    if($upper) {
        return strtoupper(trim(fgets(STDIN)));
    } else {
        return trim(fgets(STDIN));
    }

// option 2:
    $input = trim(fgets(STDIN));
    return ($upper) ? strtoupper($input) : $input;


// option 3:
    $input = trim(fgets(STDIN));
    if($upper) {
        $input = strtoupper($input);
    }
    return $input;
}

// Adding a sort function.
// Calling my getInput function to capture user input and convert it to uppercase.
// Assigning getInput to a variable, $option, so I can pass it within my function
function sortMenu($array, $defaultArray) {
    echo '(A)-Z, (Z)-A, (O)rder entered, (R)everse order entered : ';
    $option = getInput(true);
    if ($option == 'A') {
        asort($array);
    } elseif ($option == 'Z') {
        rsort($array);
    } elseif ($option == 'O') {
        $array = $defaultArray;
    } elseif ($option == 'R') {
        krsort($defaultArray);
        $array = $defaultArray;
    }
    return $array;
}

// This function takes a user defined file path as its parameter, opens the file, checks
// to see if there is data contained within the file or not - if no, error message - if yes,
// reads and trims the file data, then takes every individual line in the file and adds it
// to an array using the explode function - the resulting array is assigned to a variable and 
// returned by the function.
// Note that $contentsArray is initially assigned an empty array - this way, if there is no input
// from the file, $contentsArray has the value of an empty array and no harm or foul
// occurs when this is merged with the existing todo list - if there IS input, it is reassigned
// to this variable

function addFromFile($userDefinedFile) {
    $contentsArray = [];
    if (file_exists($userDefinedFile)) {    
        $handle = fopen($userDefinedFile, 'r');
        if (filesize($userDefinedFile) == 0) {
            echo 'This file is empty.' . PHP_EOL;
        } else {
            $contents = trim(fread($handle, filesize($userDefinedFile)));
            $contentsArray = explode(PHP_EOL, $contents);
        }
        fclose($handle);
    } else { 
        echo 'File or path specified does not exist.' . PHP_EOL;
    }
    return $contentsArray;
}

// This function takes a user defined file, opens it in 'write' mode, implodes items from the todo list array
// into strings separated by line breaks in the file and saves it, closes the file, returns file saved message

function overwriteFile($userDefinedFile, $todoList) {
    $handle = fopen($userDefinedFile, 'w');
    fwrite($handle, implode(PHP_EOL, $todoList));
    fclose($handle);
    return "$userDefinedFile was saved successfully!";
}


// The loop!
do {
    // Calls listItems function, array items get listed.
    echo listItems($items);
    // Show the menu options
    echo '(N)ew item, (R)emove item, (S)ort, (O)pen, s(A)ve, (Q)uit: ';

    // Get the input from user
    // Use trim() to remove whitespace and newlines
    $input = getInput(true);

    // Checks for actionable input, asks for entry, user input is entered as values in array $items.
    // The value of $items is assigned to $originalOrder so we can call our array values in their
    // default order later, even if $items has been resorted.
    if ($input == 'N') {
        echo 'Add item to (B)eginning or (E)nd of list? ';
        $arrayPosition = getInput(true);
        
        echo 'Enter item: ';
        $newTodo = getInput(false);

        if ($arrayPosition == 'B') {
            array_unshift($items, $newTodo);
        } else {
            array_push($items, $newTodo);
            // Below is an example of array_push shorthand
            // $items[] = $newTodo; 
            $originalOrder = $items;
        }

    // Calls a sort function, passes current todo list, sets the value of $items equal
    // to a resorted array - when it passes back through the DO loop, $items will display in their new order.
    } elseif ($input == 'S') {
        $items = sortMenu($items, $originalOrder);

    // Removes last item in array.
    } elseif ($input == 'L') {
        array_pop($items);

    // Removes first item in array.
    } elseif ($input == 'F') {
        array_shift($items);
    
    // Opens a file, reads its contents, merges with existing array using function.
    } elseif ($input == 'O') {
        echo 'Enter a valid path or file name: ';
        $readFile = getInput(false); 
        $newArray = addFromFile($readFile);
        $items = array_merge($items, $newArray);

    // Opens, writes todo list to, and saves a file using function.
    } elseif ($input == 'A') {
        echo 'Enter desired path or file name: ';
        $openFile = getInput(false);
        if(file_exists($openFile)) {
            echo "File '{$openFile}' already exists. Are you sure you want to overwrite the existing file? (Y) or (N): ";
            $fileOverwrite = getInput(true);
            if ($fileOverwrite == 'Y') {
                echo overwriteFile($openFile, $items) . PHP_EOL;
            } 
        } else {
            echo overwriteFile($openFile, $items) . PHP_EOL;
        }

    // Removes item from list.
    } elseif ($input == 'R') {
        echo 'Enter item number to remove: ';
        $key = getInput();
        // Unset removes an element from an array.
        unset($items[$key]);
    }

// Continue until input is (Q)uit.
} while ($input != 'Q');

// Say Goodbye!
echo "Goodbye!\n";

// Exit with 0 errors.
exit(0);