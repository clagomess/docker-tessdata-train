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

$arSubstituicao = array(
  'A' => '0',
  'B' => '1',
  'C' => '2',
  'D' => '3',
  'E' => '4',
  'F' => '5',
  'G' => '6',
  'H' => '7',
  'I' => '8',
  'J' => '9',
);

while(!feof(STDIN)){
    $numPlaca = trim(fgets(STDIN));

    if(empty($numPlaca)){
        continue;
    }

    $result =  $numPlaca . "-";

    if(isset($arSubstituicao[$numPlaca[5]])){
        $numPlacaBR = substr_replace($numPlaca, $arSubstituicao[$numPlaca[5]], 4, 1);
        brasil($numPlacaBR);
        $result .= "BROK-";
    }else{
        $result .= "BRNO-";
    }

    mercosul(str_replace("-", "", $numPlaca));
    $result .= "MCOK\n";
    echo $result;
}
