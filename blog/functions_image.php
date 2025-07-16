<?php

/**
 * Redimensionne une image vers une nouvelle taille.
 *
 * @param string $source_path Chemin vers l’image source.
 * @param string $dest_path   Chemin où enregistrer l’image redimensionnée.
 * @param int    $width       Largeur cible.
 * @param int    $height      Hauteur cible.
 * @return bool               true si réussi, false sinon.
 */
function resizeImage($source_path, $dest_path, $width, $height)
{
    // Récupère la largeur, la hauteur et le type MIME de l’image source
    list($src_width, $src_height, $image_type) = getimagesize($source_path);

    // Selon le type, crée une ressource image depuis le fichier source
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $src_image = imagecreatefromjpeg($source_path);
            break;
        case IMAGETYPE_PNG:
            $src_image = imagecreatefrompng($source_path);
            break;
        case IMAGETYPE_WEBP:
            $src_image = imagecreatefromwebp($source_path);
            break;
        default:
            // Si le format n'est pas pris en charge, on arrête la fonction
            return false;
    }

    // Crée une nouvelle image vierge avec les dimensions cibles
    $dst_image = imagecreatetruecolor($width, $height);

    // Copie et redimensionne l’image source dans la nouvelle image
    imagecopyresampled(
        $dst_image,    // ressource de destination
        $src_image,    // ressource source
        0,
        0,          // position (x,y) de départ dans l’image de destination
        0,
        0,          // position (x,y) de départ dans l’image source
        $width,
        $height,      // largeur et hauteur de la zone de destination
        $src_width,
        $src_height // largeur et hauteur de la zone source
    );

    // Selon le type original, enregistre l’image redimensionnée au bon format
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            imagejpeg($dst_image, $dest_path);  // JPEG
            break;
        case IMAGETYPE_PNG:
            imagepng($dst_image, $dest_path);   // PNG
            break;
        case IMAGETYPE_WEBP:
            imagewebp($dst_image, $dest_path);  // WEBP
            break;
    }

    // Libère la mémoire allouée aux deux images
    imagedestroy($src_image);
    imagedestroy($dst_image);

    // Indique que tout s’est bien passé
    return true;
}
