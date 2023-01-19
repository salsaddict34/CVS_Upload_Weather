<?php
function deleteContentFromFile_php()
{
    $url = "/var/www/private/AFPA-CDA/PHP_XDEBUG/client/src/assets/files/data.csv";
    if (isset($_POST['indice']) && isset($_POST['tabFile']) && isset($_POST['headerFile'])) {
        $temp = json_decode($_POST['tabFile']);
        $index = (int)$_POST['indice'];
        $header = json_decode($_POST['headerFile'])[0];
        $writeBuffer = "";
        if ($index === 0) {
            $buffer = "";
            $temp = array_shift($temp);
            for ($i = 1; $i < count($temp); $i++) {
                $buffer .= ";" . implode(",", $temp[$i]);
            }
            $writeBuffer = $header . "/" . implode(",", $temp[0]) . $buffer;
        } else if ($index === (count($temp) - 1)) {
            $buffer = "";
            $last = array_pop($temp);
            for ($i = 1; $i < count($temp); $i++) {
                $buffer .= ";" . implode(",", $temp[$i]);
            }
            $writeBuffer = $header . "/" . implode(",", $temp[0]) . $buffer;
        } else {
            $buffer = "";
            for ($i = 0; $i < $index; $i++) {
                $array1[$i] =  $temp[$i];
            }
            for ($i = $index + 1; $i < count($temp); $i++) {
                $array2[$i] =  $temp[$i];
            }
            $temp = array_merge($array1, $array2);
            for ($i = 1; $i < count($temp); $i++) {
                $buffer .= ";" . implode(",", $temp[$i]);
            }
            $writeBuffer = $header . "/" . implode(",", $temp[0]) . $buffer;
        }
    }
    if (file_exists($url)) {
        $file = fopen($url, "w");
        fwrite($file, $writeBuffer);
        fclose($file);
    }
    $msg = "Données supprimées du fichier.";
    $outPut = ($msg);
    echo json_encode($outPut, JSON_FORCE_OBJECT);
}
deleteContentFromFile_php();
