<?php
function write($prefix, $numPlaca){
    $fp = fopen(sprintf("%s_%s.gt.txt", $numPlaca, $prefix), 'w+');
    fwrite($fp, $numPlaca);
    fclose($fp);
}

function image_name($prefix, $numPlaca){
    return sprintf("%s_%s.png", $numPlaca, $prefix);
}

function mercosul($numPlaca){
    $img = imagecreatefrompng("bg-mercosul.png");
    $black = imagecolorallocate($img, 0, 0, 0);

    $imagename = image_name("mercosul", $numPlaca);

    imagettftext($img, 12, 0, 8, 23, $black, "./FE-FONT.ttf", $numPlaca);
    imagepng($img, $imagename);
    imagedestroy($img);

    write("mercosul", $numPlaca);
}

function brasil($numPlaca){
    $img = imagecreatefrompng("bg-brasil.png");
    $black = imagecolorallocate($img, 0, 0, 0);

    $imagename = image_name("brasil", $numPlaca);

    imagettftext($img, 12, 0, 10, 26, $black, "./MANDATOR.ttf", $numPlaca);
    imagepng($img, $imagename);
    imagedestroy($img);

    write("brasil", $numPlaca);
}

//brasil("OVR-8317");
//mercosul("BVR8317");
//exit;

$buff = array();

while(!feof(STDIN)){
    $numPlaca = trim(fgets(STDIN));

    if(empty($numPlaca)){
        continue;
    }

    echo $numPlaca . "\n";

    brasil($numPlaca);
    mercosul(str_replace("-", "", $numPlaca));
}
