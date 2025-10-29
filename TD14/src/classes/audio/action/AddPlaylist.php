<?php
declare(strict_types=1);
namespace iutnc\deefy\audio\action;

require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

use iutnc\deefy\audio\action\Action;

class AddPlaylist extends Action {

    public function execute(): string {
        session_start();

        if ($this->http_method === 'GET') {
            return <<<HTML
            <h2>Créer une nouvelle playlist</h2>
            <form method="post">
                <label>Nom de la playlist :</label>
                <input type="text" name="playlist_name" required>
                <button type="submit">Créer</button>
            </form>
            HTML;
        }

        // Si POST :
        $name = $_POST['playlist_name'] ?? 'Nouvelle playlist';
        $_SESSION['playlist_name'] = $name;
        $_SESSION['playlist'] = [];

        return "<p>Playlist <strong>$name</strong> créée avec succès </p>";
    }
}
