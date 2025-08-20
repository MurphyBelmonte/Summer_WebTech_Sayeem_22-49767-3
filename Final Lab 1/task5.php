<?php
$str = "HelloWorld";
$vowels = "";
$consonants = "";

$letters = str_split(strtolower($str));
foreach ($letters as $ch) {
    if (ctype_alpha($ch)) { // only letters
        if (in_array($ch, ['a','e','i','o','u'])) {
            $vowels .= $ch;
        } else {
            $consonants .= $ch;
        }
    }
}

echo "Original: $str <br>";
echo "Vowels: $vowels <br>";
echo "Consonants: $consonants";
?>
