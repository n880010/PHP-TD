<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\audio\action\Action;

class AddPodcastTrackAction extends Action {

    public function execute(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Création du singleton deefyrepository pour manipuler la BDD
        $repo = DeefyRepository::getInstance();
        // Si l'id n'existe pas dans la BDD , il faut se connecter
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return "<p style='color:red'>Vous devez être connecté pour ajouter un track.</p>";
        }

        // Récupérer les playlists de l'utilisateur
        $playlists = $repo->findPlaylistsByUserId($userId);
        // Si aucune playlist , il faut en créer au moins une
        if (empty($playlists)) {
            return "<p>Veuillez d’abord créer une playlist avant d’ajouter un track.</p>";
        }

        // --- GET : formulaire ---
        if ($this->http_method === 'GET') {
            $options = '';
            // On parcourt toutes les playlist de l'user et on les ajoutes dans le formulaire
            foreach ($playlists as $pl) {
                $options .= '<option value="' . $pl['id'] . '">' . htmlspecialchars($pl['nom']) . '</option>';
            }

            return <<<HTML
            <h2>Ajouter un track à une playlist</h2>
            <form method="post">
                <label>Titre du track :</label>
                <input type="text" name="track" required><br><br>

                <label>Durée (en secondes) :</label>
                <input type="number" name="duration" min="1" required><br><br>

                <label>Playlist :</label>
                <select name="playlist_id" required>
                    $options
                </select><br><br>

                <button type="submit">Ajouter</button>
            </form>
            HTML;
        }

        // --- POST : traitement du formulaire ---
        // On recupere ce quil y'a dans le post
        $trackName = trim($_POST['track'] ?? '');
        $duration = (int)($_POST['duration'] ?? 0);
        $playlistId = (int)($_POST['playlist_id'] ?? 0);

        // Si un des 3 champs est vide , on retourne une erreur
        if (!$trackName || !$duration || !$playlistId) {
            return "<p style='color:red;'>Veuillez remplir tous les champs correctement.</p>";
        }

        // On sauvegarde le track dans la base de donnée
        $trackId = $repo->savePodcastTrack($trackName, 'podcast', '', 'mp3', $duration);

        // Ajouter le track à la playlist
        $existingTracks = $repo->findTracksByPlaylist($playlistId);
        // On met a jour le nombre de pistes
        $noPiste = count($existingTracks) + 1;
        // On ajoute le track a la playlist
        $repo->addTrackToPlaylist($playlistId, $trackId, $noPiste);

        // Mettre à jour la durée totale de la playlist
        $totalDuration = array_sum(array_column($existingTracks, 'duree')) + $duration;
        $stmt = $repo->getPDO()->prepare("UPDATE playlist SET duree = ? WHERE id = ?");
        $stmt->execute([$totalDuration, $playlistId]);

        return "<p>Track <strong>$trackName</strong> ajouté à la playlist. Durée totale mise à jour : {$totalDuration}s.</p>";
    }
}
