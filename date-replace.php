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
function dateReplace ($directory, $newDate, $outputDirectory) {
  // si l'ouverture de pépertoir est ok
  if ($handle = opendir($directory)) {
    // on traverse le répertoire temps qu'il reste des entrées
    while (false !== ($entry = readdir($handle))) {
      // on teste si c'est un fichier
      if ($entry != "." && $entry != "..") {
        // je stocke le contenus du fichier dans une variable
        $string = file_get_contents($directory.$entry);
        // ma regex qui cherche les dates
        $pattern = '/(Date=")([0-9-]{10})(")/';
        // je remplace les dates dans le contenu
        $content = preg_replace($pattern, 'Date="'. $newDate . '"', $string);
        // j'insert le contenu dans un nouveau fichier
        file_put_contents($outputDirectory . $entry, $content);
      }
    }
    // je ferme le répertoire
    closedir($handle);
  }
}

//////////////////////////////////

$directory = __DIR__ . '/files/';
$outputDirectory = __DIR__ . '/files2/';
$newDate = '2016-01-05';

dateReplace($directory, $newDate, $outputDirectory);
?>
