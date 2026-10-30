<?php
$file = 'c:/xampp/htdocs/newmateial/resources/views/products/show.blade.php';
$content = file_get_contents($file);

// Replace the mangled symbols with the correct emojis
$content = str_replace('ðŸ“ ', '📍', $content);
$content = str_replace('ðŸ ¢', '🏢', $content);

file_put_contents($file, $content);
echo "Emojis replaced.\n";
