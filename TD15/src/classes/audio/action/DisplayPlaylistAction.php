<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use iutnc\deefy\auth\Authz;
use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\render\AudioListRenderer;

class DisplayPlaylistAction extends Action {

    public function execute(): string {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // On recupère l'ID de la session en GET
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            return "<p>Playlist invalide.</p>";
        }

        try {
            // Vérifie que l’utilisateur a le droit d’y accéder
            Authz::checkPlaylistOwner($id);

            // Création du singleton pour manipuler la BDD
            $repo = DeefyRepository::getInstance();
            // On recupere la playlist associés a l'ID $id
            $playlist = $repo->findPlaylistById($id); // objet Playlist déjà créé

            // Récupère les pistes depuis la base
            $tracksData = $repo->findTracksByPlaylist($id);
            $tracks = [];
            foreach ($tracksData as $row) {
                $tracks[] = new AudioTrack(
                    $row['titre'],
                    $row['genre'],
                    $row['filename'],
                    isset($row['duree']) ? (int)$row['duree'] : 0
                );
            }
            // Puis on associe les tracks au playlist avec mettreAJourProprietes
            // Met à jour les pistes dans l'objet Playlist
            $playlist->mettreAJourProprietes($tracks);

            // Rend la playlist
            $renderer = new AudioListRenderer($playlist);
            return $renderer->render();

        } catch (\Exception $e) {
            return "<p style='color:red'>" . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
}
