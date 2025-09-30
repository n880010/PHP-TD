<?php

declare(strict_types=1);
require_once 'AlbumTrack.php';
require_once 'AlbumTrackRenderer.php';
require_once 'PodcastTrack.php';
require_once 'PodcastTrackRenderer.php';
require_once 'AudioTrackRenderer.php';


$tr1 = new AlbumTrack('Titre 1','audio/audio2.mp3','Album 1',1,"Rock");
$tr2 = new AlbumTrack('Titre 2','audio/audio3.mp3','Album 2',2,"Rock");
echo $tr1->__toString();
echo "<br>";
print_r($tr2->__toString());
echo "<br>";
var_dump($tr1->__toString());
echo "<br>";

$tr_render1 = new AlbumTrackRenderer($tr2);

echo $tr_render1->renderCompact();
echo "<br>";
echo $tr_render1->renderLong();
echo "<br>";

$p1 = new PodcastTrack(
    "Les infos du jour",       // titre
    "audio/audio1.mp3",       // fichier audio
    "Journal Quotidien",       // nom de l'émission
    "Jean Dupont",             // animateur
    "Artiste",                        // artiste (facultatif)
    1800,                      // durée en secondes (facultatif)
    "Actualités"               // genre (facultatif)
);

// Affichage JSON

$p1_render1 = new PodcastTrackRenderer($p1);
echo $p1_render1->renderCompact();
echo "<br>";
echo $p1_render1->renderLong();
echo "<br>";


echo "-----------------------------------------------------------------------------------------------------------------------";
echo $p1_render1->render(1);
echo "<br>";
echo $tr_render1->render(2);
echo "<br>";


