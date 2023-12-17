<?php

namespace CuttingEdgeTeam\LaravelWebpPackage;
require 'ConvertImage.php';

class ConvertArray
{
    public static function convertToWebp($images_array, $webpPath, $quality){
        foreach($images_array as $file){
            ConvertImage::convertToWebp($file,$webpPath,$quality);
        }
    }
}

ConvertArray::convertToWebp(["./uploads/img.png","./uploads/img2.png"],"./webp/",100);