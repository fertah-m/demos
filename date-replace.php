<?php
/**
 * Remplace les dates dans les fichiers du répertoire
 *
 * @param $directory le chemin vers le répertoire
 * @param $newDate La date de remplacement (Format: USA)
 * @param $outputDirectory le chemin vers le répertoire de sortie
 *
 * @return void
 */
function dateReplace($directory, $newDate, $outputDirectory)
{
    if ($handle = opendir($directory)) {
        // on traverse le répertoire temps qu'il reste des entrées
        while (false !== ($entry = readdir($handle))) {
            // on check si c'est bien un fichier
            if ($entry != "." && $entry != "..") {
                $string = file_get_contents($directory . $entry);
                $pattern = '/(Date=")([0-9-]{10})(")/';
                $content = preg_replace($pattern, 'Date="' . $newDate . '"', $string);
                file_put_contents($outputDirectory . $entry, $content);
            }
        }
        closedir($handle);
    }
}

//////////////////////////////////

$directory = __DIR__ . '/files/';
$outputDirectory = __DIR__ . '/files2/';
$newDate = '2016-01-05';

dateReplace($directory, $newDate, $outputDirectory);
?>
