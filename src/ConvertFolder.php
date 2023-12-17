<?php

namespace CuttingEdgeTeam\LaravelWebpPackage;
require 'ConvertImage.php';

class ConvertFolder
{
    public static function convertToWebp($target_folder, $webpPath, $quality){
        $files = glob($target_folder . '/*.{jpg,png,jpeg,svg}',GLOB_BRACE);
        foreach($files as $file){
            ConvertImage::convertToWebp($file,$webpPath,$quality);
        }
    }
}

ConvertFolder::convertToWebp("./uploads","./webp/",100);