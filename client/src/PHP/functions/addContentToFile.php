<?php
function addContentToFile_php()
{
    $url = "/var/www/private/AFPA-CDA/PHP_XDEBUG/client/src/assets/files/data.csv";
    if (isset($_POST['lastName']) && isset($_POST['firstName']) && isset($_POST['age']) && isset($_POST['formation'])) {

        $writeBuffer = ";" . $_POST['lastName'] . "," . $_POST['firstName'] . "," . $_POST['age'] . "," . $_POST['formation'];
    }
    if (file_exists($url)) {
        $file = fopen($url, "a");
        fwrite($file, $writeBuffer);
        fclose($file);
    }
    $msg = "Données ajoutées au fichier.";
    $outPut = ($msg);
    echo json_encode($outPut, JSON_FORCE_OBJECT);
}
addContentToFile_php();
