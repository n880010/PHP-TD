<?php
declare(strict_types=1);
namespace iutnc\deefy\audio\action;

require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

use iutnc\deefy\audio\action\Action;

class DisplayPlaylist extends Action {  
    public function execute(): string {
        session_start();
        if (!isset($_SESSION['playlist'])) {
            return "<p>Veuillez d’abord créer une playlist avant d’ajouter un morceau.</p>";
        }
        $playlist = $_SESSION['playlist'];
        return "Playlist : " . json_encode($playlist) . " & Nom de la Playlist : ".json_encode($_SESSION['playlist_name']);
    }
}

























