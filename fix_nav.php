<?php

$file = __DIR__ . '/resources/views/layouts/app.blade.php';
$content = file_get_contents($file);

// Fix: if `<a` exists just before `<a href="/packages"`
$content = preg_replace('/<a\s+(<a\s+href="\/packages")/s', '$1', $content);

// Fix: if `href="/inspiration"` is missing its opening `<a`
$content = preg_replace('/(<\/a>\s+)(href="\/inspiration")/s', '$1<a $2', $content);

file_put_contents($file, $content);
echo "NAV_FIXED_SUCCESSFULLY\n";
