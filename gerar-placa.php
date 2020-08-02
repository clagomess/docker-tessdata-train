<?php
function write($prefix, $numPlaca){
    $fp = fopen(sprintf("%s_%s.gt.txt", md5($numPlaca), $prefix), 'w+');
    fwrite($fp, $numPlaca);
    fclose($fp);
}

function image_name($prefix, $numPlaca){
    return sprintf("%s_%s.png", md5($numPlaca), $prefix);
}

function mercosul($numPlaca){
    $img = imagecreate(195 * 10, 45);
    imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);

    $imagename = image_name("mercosul", $numPlaca);

    imagettftext($img, 30, 0, 5, 35, $black, "./FE-FONT.ttf", $numPlaca);
    imagepng($img, $imagename);
    imagedestroy($img);

    write("mercosul", $numPlaca);
}

function brasil($numPlaca){
    $img = imagecreate(186 * 10, 40);
    imagecolorallocate($img, 255, 255, 255);
    $black = imagecolorallocate($img, 0, 0, 0);

    $imagename = image_name("brasil", $numPlaca);

    imagettftext($img, 30, 0, 5, 35, $black, "./MANDATOR.ttf", $numPlaca);
    imagepng($img, $imagename);
    imagedestroy($img);

    write("brasil", $numPlaca);
}

//brasil("OVR-8317 OVR-8317 OVR-8317 OVR-8317 OVR-8317 OVR-8317 OVR-8317 OVR-8317 OVR-8317 OVR-9999");
//mercosul("OVR8317 OVR8317 OVR8317 OVR8317 OVR8317 OVR8317 OVR8317 OVR8317 OVR8317 OVR9999");
//exit;

$buff = array();

while(!feof(STDIN)){
    $numPlaca = trim(fgets(STDIN));

    if(empty($numPlaca)){
        continue;
    }

    $buff[] = $numPlaca;

    if(count($buff) == 10) {
        $numPlacas = implode(" ", $buff);
        echo $numPlacas . "\n";

        if ($argv[1] == "brasil") {
            brasil($numPlacas);
        }

        if ($argv[1] == "mercosul") {
            mercosul($numPlacas);
        }

        $buff = array();
    }
}
