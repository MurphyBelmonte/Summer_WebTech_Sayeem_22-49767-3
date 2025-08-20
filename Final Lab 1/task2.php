<?php
$arr = [10, 45, 32, 67, 89, 67];

// Remove duplicates
$uniqueArr = array_unique($arr);

// Sort in descending order
rsort($uniqueArr);

if(count($uniqueArr) >= 2){
    echo "Second Maximum: " . $uniqueArr[1];
} else {
    echo "Array does not have a second maximum.";
}
?>
