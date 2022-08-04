<?php

//formatear fecha 

function formatear_fecha($fecha) {
    return date ('d M, Y, g:i a', strtotime($fecha));
}

//formatear texto corto

function texto_corto($text, $chars = 50) {
    $text = $text."";
    $text = substr($text, 0, $chars);
    $text = substr($text, 0, strrpos($text, ' '));
    $text = $text."...";
    return $text;
}


?>