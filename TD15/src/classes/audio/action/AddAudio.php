<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;

require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

use iutnc\deefy\audio\action\Action;
use iutnc\deefy\repository\DeefyRepository;

class AddAudio extends Action {

    private function handleUpload(): string {
        if (!isset($_FILES['userfile']) || $_FILES['userfile']['error'] !== UPLOAD_ERR_OK) {
            return "<p style='color:red;'>Erreur pendant l'envoi du fichier.</p>";
        }

        $fichier = $_FILES['userfile'];

        // Vérifie que c'est bien un MP3
        if (substr($fichier['name'], -4) !== '.mp3' || $fichier['type'] !== 'audio/mpeg') {
            return "<p style='color:red;'>Le fichier doit être un MP3 valide.</p>";
        }

        // Vérifie qu'une playlist a été choisie
        $playlistId = (int)($_POST['playlist_id'] ?? 0);
        if ($playlistId === 0) {
            return "<p style='color:red;'>Veuillez sélectionner une playlist.</p>";
        }

        // Crée un nom unique pour éviter les doublons
        $nouveau_nom = uniqid('track_', true) . '.mp3';
        $destination = __DIR__ . '/../../audio/' . $nouveau_nom;

        move_uploaded_file($fichier['tmp_name'], $destination);

        // Sauvegarde le track dans la BDD
        $repo = DeefyRepository::getInstance();
        $trackId = $repo->savePodcastTrack($fichier['name'], 'inconnu', $nouveau_nom, 'mp3');

        // Ajoute le track à la playlist
        $existingTracks = $repo->findTracksByPlaylist($playlistId);
        $noPiste = count($existingTracks) + 1;
        $repo->addTrackToPlaylist($playlistId, $trackId, $noPiste);

        return "<p style='color:green;'>Fichier MP3 uploadé et ajouté à la playlist avec succès !</p>";
    }

    public function execute(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $repo = DeefyRepository::getInstance();
        // on recupere l'user ID si ya rien c'est null
        // ( user est un tableau qu'on stock dans la session depuis SigninAction.php)
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            // Si l'utilisateur n'est pas connécté on retourne un message d'erreur
            return "<p style='color:red;'>Vous devez être connecté pour ajouter un fichier audio.</p>";
        }

        // Récupère les playlists de l'utilisateur
        $playlists = $repo->findPlaylistsByUserId($userId);

        // Si l'utilisateur accede a la page en GET
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // On recupere toutes ces playlists et on en fait un menu déroulant
            $options = '';
            foreach ($playlists as $pl) {
                // Pour éviter l'injection
                $options .= '<option value="' . $pl['id'] . '">' . htmlspecialchars($pl['nom']) . '</option>';
            }

            // Formulaire
            return <<<HTML
            <h2>Ajouter un fichier audio</h2>
            <form method="post" enctype="multipart/form-data" action="?action=add-audio">
                <label for="userfile">Choisir un fichier audio (.mp3) :</label><br>
                <input type="file" name="userfile" id="userfile" accept=".mp3,audio/mpeg" required><br><br>

                <label for="playlist">Ajouter à la playlist :</label>
                <select name="playlist_id" id="playlist" required>
                    $options
                </select><br><br>

                <button type="submit">Uploader</button>
            </form>
            HTML;
        }

        // Une fois que le formulaire est envoyée on recupere en POST et on apelle la méthode
        // --- POST ---
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->handleUpload();
        }
        // Si c'est HEAD ou autre ya rien a faire

        return "<p>Erreur : méthode HTTP non supportée.</p>";
    }
}
