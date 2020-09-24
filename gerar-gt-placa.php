<?php
function write($filename, $numPlaca){
    $fp = fopen(sprintf("./placas/%s.gt.txt", $filename), 'w+');
    fwrite($fp, $numPlaca);
    fclose($fp);
}

if ($handle = opendir('./placas')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            $entry = str_replace(".png", "", $entry);
            $numPlaca = substr($entry, 0, 7);

            write($entry, $numPlaca);

            echo "$entry\n";
        }
    }

    closedir($handle);
}