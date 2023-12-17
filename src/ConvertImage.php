<?php

namespace CuttingEdgeTeam\LaravelWebpPackage;

class ConvertImage
{
    public static function convertToWebp(mixed $filePath, $webpPath, $quality = 100){

        $uploadOk = 1;

        //Hold the file extension of the file (in lower case)
        $imageFileType = strtolower(pathinfo($filePath,PATHINFO_EXTENSION));

        //Check if image file is a actual image or fake image
        $check = getimagesize($filePath);
        if($check) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
         
        // Check if file already exists
        // if (file_exists($filePath)) {
        //     echo "Sorry, file already exists.";
        //     $uploadOk = 0;
        // }

        // Allow certain file formats
        if(!in_array($imageFileType ,["jpg", "png", "jpeg","svg"])) {
            echo "Sorry, only JPG, JPEG, PNG & SVG files are allowed.";
            $uploadOk = 0;
        }

        // Load the png,jpg,jpeg,svg image
        switch ($imageFileType) {
            case 'png':
                $targetImage = imagecreatefrompng($filePath);
                break;
            case 'jpg':
            case 'jpeg':
                $targetImage = imagecreatefromjpeg($filePath);
                break;
            case 'svg':
                $targetImage = imagecreatefromstring($filePath);
                break;
            default:
                echo "Sorry, only JPG, JPEG, PNG & SVG files are allowed.";
          }

        // Create an empty WebP image
        $webpPath = $webpPath.rand().'.webp';
        $webpImage = imagecreatetruecolor(imagesx($targetImage), imagesy($targetImage));

        // Convert the PNG image to WebP
        imagecopy($webpImage, $targetImage, 0, 0, 0, 0, imagesx($targetImage), imagesy($targetImage));
        imagewebp($webpImage, $webpPath,$quality);

        // Clean up
        imagedestroy($targetImage);
        imagedestroy($webpImage);

        echo 'Conversion completed';

    }
}

ConvertImage::convertToWebp("./uploads/img.png","./webp/",100);