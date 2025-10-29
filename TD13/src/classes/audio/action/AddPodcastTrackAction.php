<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;

require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

use iutnc\deefy\audio\action\Action;

class AddPodcastTrackAction extends Action {

    public function execute(): string {
        session_start();

        if (!isset($_SESSION['playlist'])) {
            return "<p>Veuillez d’abord créer une playlist avant d’ajouter un morceau.</p>";
        }

        if ($this->http_method === 'GET') {
            return <<<HTML
            <h2>Ajouter un track à la playlist</h2>
            <form method="post">
                <label>Titre du podcast :</label>
                <input type="text" name="track" required>
                <button type="submit">Ajouter</button>
            </form>
            HTML;
        }

        // Si POST :
        $track = $_POST['track'] ?? '';
        $_SESSION['playlist'][] = $track;

        return "<p>Track <strong>$track</strong> ajouté à la playlist </p>";
    }
}
