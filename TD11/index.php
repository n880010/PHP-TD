<?php
declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\lists\AlbumList;
use iutnc\deefy\render\AlbumTrackRenderer;
use iutnc\deefy\render\AudioListRenderer;

echo "Démo de l'autoload PSR-4 pour iutnc\\deefy\\ -> src/classes/\n";

$tr1 = new AlbumTrack('Titre 1', 'audio/audio2.mp3', 'Album 1', 1, "Rock", 180);
$tr2 = new AlbumTrack('Titre 2', 'audio/audio3.mp3', 'Album 2', 2, "Rock", 240, "Artiste 1");

$album = new AlbumList("Mon Album",[$tr1, $tr2]);

echo (new AudioListRenderer($album))->render();
?>
