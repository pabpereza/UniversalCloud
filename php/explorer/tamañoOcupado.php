<?php
session_start();
$path = "../../CloudFiles/" . $_SESSION['usuario']['idusuarios'];

$GLOBALS['ocupado'] = 0;
contarOcupado($path);
$GLOBALS['ocupado'] = FileSizeConvert($GLOBALS['ocupado']);
echo $GLOBALS['ocupado'];

function contarOcupado($path) {
    $path = rtrim(strval($path), '/');

    $d = dir($path);

    if (!$d)
        return false;

    while (false !== ($current = $d->read())) {
        if ($current === '.' || $current === '..')
            continue;

        $file = $d->path . '/' . $current;

        if (is_dir($file))
            contarOcupado($file);

        if (is_file($file))
            $GLOBALS['ocupado'] += filesize($file);
    }

    $d->close();
    return true;
}

function FileSizeConvert($bytes) {
    $bytes = floatval($bytes);
    $arBytes = array(
        0 => array(
            "UNIT" => "TB",
            "VALUE" => pow(1024, 4)
        ),
        1 => array(
            "UNIT" => "GB",
            "VALUE" => pow(1024, 3)
        ),
        2 => array(
            "UNIT" => "MB",
            "VALUE" => pow(1024, 2)
        ),
        3 => array(
            "UNIT" => "KB",
            "VALUE" => 1024
        ),
        4 => array(
            "UNIT" => "B",
            "VALUE" => 1
        ),
    );
    $result = "";
    foreach ($arBytes as $arItem) {
        if ($bytes >= $arItem["VALUE"]) {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", ",", strval(round($result, 2))) . " " . $arItem["UNIT"];
            break;
        }
    }
    return $result;
}