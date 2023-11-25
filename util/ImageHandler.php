<?php

class ImageHandler{
    public function base64ToBin($base64Data){
        $result = array(
            "data" => null,
            "format" => ""
        );

        $binaryData = $base64Data;
        list($format, $binaryData) = explode( ";", $binaryData );
        list(, $binaryData) = explode( ",", $binaryData );

        $result['data'] = base64_decode( $binaryData );
        $result['format'] = $format;

        return $result;
    }
}