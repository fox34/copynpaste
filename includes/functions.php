<?php

declare(strict_types = 1);
namespace noecho\copynpaste;


// https://github.com/briancray/PHP-URL-Shortener
// edited to exclude ambiguous characters: 0, 1, o, O, i, j, l, I, J
function encodeShortURL(int $number) : string
{
    $codeset = '23456789abcdefghkmnpqrstuvwxyzABCDEFGHKLMNPQRSTUVWXYZ';
    $base = strlen($codeset);
    
    $out = '';
    while ($number > $base - 1) {
        $out = $codeset[(int)fmod($number, $base)] . $out;
        $number = (int)floor($number / $base);
    }
    return $codeset[$number] . $out;
}

function showErrorPage(string $errorMsg)
{
    $error = $errorMsg;
    require BASEDIR . 'templates/error.php';
    exit;
}

function getNextID(): string
{
    // counter file can be stored in target folder, since valid ids never begin with an underscore
    $counterFile = $GLOBALS['configuration']['targetFolder'] . '_counter.txt';
    
    if (!file_exists($counterFile)) {
        $currentID = 0;
    } else {
        $currentID = (int)file_get_contents($counterFile);
    }
    
    file_put_contents($counterFile, (string)++$currentID, LOCK_EX);
    
    // generate some randomness to prevent guessing
    return
        encodeShortURL($currentID) .
        encodeShortURL(random_int((int)1e3, (int)1e4)) .
        encodeShortURL(random_int((int)1e2, (int)1e3));
}
