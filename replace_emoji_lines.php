<?php
$file = 'c:/xampp/htdocs/newmateial/resources/views/products/show.blade.php';
$lines = file($file);

$lines[1193] = "                            <span>🏢</span>\n";
$lines[1341] = "                                <span>📍</span>\n";

file_put_contents($file, implode("", $lines));
echo "Lines replaced successfully.\n";
