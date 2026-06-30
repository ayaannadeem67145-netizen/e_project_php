<?php
function resizeImage($source, $destination, $maxWidth, $maxHeight) {
    $imageInfo = getimagesize($source);
    $width = $imageInfo[0];
    $height = $imageInfo[1];
    $mime = $imageInfo['mime'];

    switch ($mime) {
        case 'image/jpeg':
            $image = imagecreatefromjpeg($source);
            break;
        case 'image/png':
            $image = imagecreatefrompng($source);
            break;
        default:
            return false;
    }

    $ratio = min($maxWidth / $width, $maxHeight / $height);
    $newWidth = (int)($width * $ratio);
    $newHeight = (int)($height * $ratio);

    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if ($mime == 'image/jpeg') {
        imagejpeg($resizedImage, $destination, 85);
    } else {
        imagepng($resizedImage, $destination);
    }

    return true;
}
?>
