<?php
function deleteImageFile()
{
    if (isset($_POST['file'])) {
        $url = $_POST['file'];
        $target = $url[0] . "/" . $url[1];
        if (file_exists($target)) {
            unlink($target);
            $msg = "Fichier supprimé.";
        } else {
            $msg = "Le fichier n'existe pas !";
        }
    } else {
        $msg = "L'URL est vide !";
    }

    $outPut = ($msg);
    echo json_encode($outPut, JSON_FORCE_OBJECT);
}
deleteImageFile();
