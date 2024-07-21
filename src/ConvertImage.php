<?php

namespace CuttingEdgeTeam\LaravelWebpPackage;

class ConvertImage
{
    public static function convertToWebp(mixed $filePath, string $webpFolder, string $webpName = null)
    {

        $uploadOk = 1;

        // Check if the file exists
        if (!file_exists($filePath)) {
            echo "Sorry, file does not exist.";
            $uploadOk = 0;
        }

        //Hold the file extension of the file (in lower case)
        $imageFileType = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        //Check if image file is a actual image or fake image
        if ($uploadOk == 1) {
            $check = getimagesize($filePath);
            if ($check) {
                echo "File is an image - " . $check["mime"] . ". ";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Allow certain file formats
        if ($uploadOk == 1 && !in_array($imageFileType, ["jpg", "png", "jpeg", "svg"])) {
            echo "Sorry, only JPG, JPEG, PNG & SVG files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "File is not valid for conversion.";
            return;
        }

        // Create the folder if it doesn't exist
        if (!is_dir($webpFolder)) {
            echo "hi";
            if (!mkdir($webpFolder, 0777, true)) {
                echo "Failed to create folder: $webpFolder";
                return;
            }
        }

        // Generate a random name if no name is provided
        if (is_null($webpName) || empty($webpName)) {
            $webpName = rand();
        }

        // Define the complete path for the WebP image
        $webpPath = $webpFolder . '/' . $webpName . '.webp';

        // Check if the specified name already exists
        if (file_exists($webpPath)) {
            echo "Sorry, the file name is already taken.";
            return;
        }

        // Load the png,jpg,jpeg,svg image
        $targetImage = match ($imageFileType) {
            "png" =>  imagecreatefrompng($filePath),
            "jpg", "jpeg" =>  imagecreatefromjpeg($filePath),
            "svg" =>  imagecreatefromstring($filePath),
            default =>  "Sorry, only JPG, JPEG, PNG & SVG files are allowed.",
            // case 'png':
            //     $targetImage = imagecreatefrompng($filePath);
            //     break;
            // case 'jpg':
            // case 'jpeg':
            //     $targetImage = imagecreatefromjpeg($filePath);
            //     break;
            // case 'svg':
            //     $targetImage = imagecreatefromstring($filePath);
            //     break;
            // default:
            //     echo "Sorry, only JPG, JPEG, PNG & SVG files are allowed.";
        };

        // Create an empty WebP image
        // $webpFolder = $webpFolder . rand() . '.webp';
        $webpImage = imagecreatetruecolor(imagesx($targetImage), imagesy($targetImage));
        $quality = 75;

        // Convert the PNG image to WebP
        imagecopy($webpImage, $targetImage, 0, 0, 0, 0, imagesx($targetImage), imagesy($targetImage));
        imagewebp($webpImage, $webpPath, $quality);

        // Clean up
        imagedestroy($targetImage);
        imagedestroy($webpImage);

        echo 'Conversion completed: ' . $webpPath;
    }
}

ini_set('memory_limit', '1024M');

// ConvertImage::convertToWebp("../uploads/img2.jpg", "../webp");
ConvertImage::convertToWebp("../uploads/img.png", "../webp/webp1", "new_webp2");
