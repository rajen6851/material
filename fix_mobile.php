<?php
$file = 'resources/views/layouts/app.blade.php';
$content = file_get_contents($file);

// Add flex-wrap and justify-center to the announcement bar flex container
$content = str_replace('<div class="flex items-center gap-4 sm:gap-6 text-xs text-[#a8a29e]">', '<div class="flex flex-wrap justify-center items-center gap-2 sm:gap-6 text-[10px] sm:text-xs text-[#a8a29e]">', $content);

// Make email hidden on mobile to save space, and ensure the | separator is hidden correctly
$content = str_replace('<a href="mailto:{{ $siteSettings?->email ?? \'pristoenterprises@gmail.com\' }}" class="hover:text-[#c09b5a] transition flex items-center gap-1.5 text-[#d6d0c7]">', '<a href="mailto:{{ $siteSettings?->email ?? \'pristoenterprises@gmail.com\' }}" class="hover:text-[#c09b5a] transition hidden sm:flex items-center gap-1.5 text-[#d6d0c7]">', $content);

// Ensure the second | separator is also hidden on mobile
$content = str_replace('<span class="text-[#44403c]">|</span>', '<span class="text-[#44403c] hidden sm:inline">|</span>', $content);

// Fix the main container in the topbar to have flex-wrap as well
$content = str_replace('<div class="max-w-[1500px] mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">', '<div class="max-w-[1500px] mx-auto flex flex-col sm:flex-row justify-center sm:justify-between items-center gap-2">', $content);

file_put_contents($file, $content);
echo "Updated mobile view for topbar.\n";
