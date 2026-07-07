<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);

foreach ($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    
    // Replace !str_starts_with(..., '/storage/')
    // Match anything in the variable position, e.g. $b->cover_image or $item['cover_image'] ?? ''
    $pattern1 = "/!str_starts_with\(([^,]+?),\s*'\/storage\/'\)/";
    $replacement1 = "(!str_starts_with($1, '/storage/') && !str_starts_with($1, 'http'))";
    
    // Replace str_starts_with(..., '/storage/') that doesn't have a '!'
    $pattern2 = "/(?<!\!)str_starts_with\(([^,]+?),\s*'\/storage\/'\)/";
    $replacement2 = "(str_starts_with($1, '/storage/') || str_starts_with($1, 'http'))";

    $newContent = preg_replace($pattern1, $replacement1, $content);
    $newContent = preg_replace($pattern2, $replacement2, $newContent);
    
    if ($content !== $newContent) {
        file_put_contents($path, $newContent);
        echo "Updated: $path\n";
    }
}
echo "Done!\n";
