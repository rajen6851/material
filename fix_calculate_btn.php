<?php
$file = 'c:/xampp/htdocs/newmateial/resources/views/products/show.blade.php';
$lines = file($file);

$lines[1920] = '                            class="w-full bg-[#b58d56] hover:bg-[#c09b5a] !text-white font-bold py-3 rounded-xl transition text-sm"' . "\n";

file_put_contents($file, implode("", $lines));
echo "Calculate button fixed.\n";
