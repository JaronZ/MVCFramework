<?php
function autoload($dir){
    // Add backslash to dir if not set
    if(!in_array(substr($dir, -1), array("/", "\\"))){
        $dir = $dir."\\";
    }
    // Get all files/directories in the chosen directory
    $files = array_diff(scandir($dir), array(".", ".."));
    foreach($files as $file){
        $file = $dir.$file;
        // If the file path is a directory, autoload it
        // Otherwise include it
        is_dir($file) ? autoload($file) : include($file);
    }
}
