<?php
declare(strict_types=1);

// Chargement manuel de toutes les classes
require_once 'src/iutnc/deefy/exception/InvalidPropertyNameException.php';
require_once 'src/iutnc/deefy/exception/InvalidPropertyValueException.php';

require_once 'src/iutnc/deefy/audio/tracks/AudioTrack.php';
require_once 'src/iutnc/deefy/audio/tracks/AlbumTrack.php';
require_once 'src/iutnc/deefy/audio/tracks/PodcastTrack.php';

require_once 'src/iutnc/deefy/audio/lists/AudioList.php';
require_once 'src/iutnc/deefy/audio/lists/AlbumList.php';
require_once 'src/iutnc/deefy/audio/lists/Playlist.php';

require_once 'src/iutnc/deefy/render/Renderer.php';
require_once 'src/iutnc/deefy/render/AudioTrackRenderer.php';
require_once 'src/iutnc/deefy/render/AlbumTrackRenderer.php';
require_once 'src/iutnc/deefy/render/PodcastTrackRenderer.php';
require_once 'src/iutnc/deefy/render/AudioListRenderer.php';

// Importation des classes
use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\audio\lists\AlbumList;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AlbumTrackRenderer;
use iutnc\deefy\render\PodcastTrackRenderer;
use iutnc\deefy\render\AudioListRenderer;

try {
    echo "<h1>Test des pistes audio</h1>";
    
    // Création de pistes d'album avec durée
    $tr1 = new AlbumTrack('Titre 1', 'audio/audio2.mp3', 'Album 1', 1, "Rock", 180);
    $tr2 = new AlbumTrack('Titre 2', 'audio/audio3.mp3', 'Album 2', 2, "Rock", 240, "Artiste 1");

    echo "<h2>Test toString()</h2>";
    echo $tr1->__toString();
    echo "<br>";
    echo $tr2->__toString();
    echo "<br>";

    // Rendu d'une piste d'album
    echo "<h2>Rendu AlbumTrack</h2>";
    $tr_render1 = new AlbumTrackRenderer($tr2);
    echo $tr_render1->render(1); // Compact
    echo "<br>";
    echo $tr_render1->render(2); // Long
    echo "<br>";

    // Création d'un podcast
    echo "<h2>Rendu PodcastTrack</h2>";
    $p1 = new PodcastTrack(
        "Les infos du jour",
        "audio/audio1.mp3",
        "Journal Quotidien",
        "Jean Dupont",
        "Artiste Podcast",
        1800,
        "Actualités"
    );

    // Rendu d'un podcast
    $p1_render1 = new PodcastTrackRenderer($p1);
    echo $p1_render1->render(1); // Compact
    echo "<br>";
    echo $p1_render1->render(2); // Long
    echo "<br>";

    // Test des listes
    echo "<h2>Test des listes</h2>";
    
    // AlbumList
    $album = new AlbumList("Mon Album", [$tr1, $tr2]);
    $album->setArtiste("Artiste Principal");
    $album->setDate("2024");
    
    $albumRenderer = new AudioListRenderer($album);
    echo $albumRenderer->render();
    echo "<br>";

    // Playlist
    $playlist = new Playlist("Ma Playlist");
    $playlist->ajouterPiste($tr1);
    $playlist->ajouterPiste($p1);
    
    $playlistRenderer = new AudioListRenderer($playlist);
    echo $playlistRenderer->render();

} catch (Exception $e) {
    echo "<h2>Erreur</h2>";
    echo "Message : " . $e->getMessage();
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}