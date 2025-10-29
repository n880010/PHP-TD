<?php
declare(strict_types=1);


namespace iutnc\deefy\audio\action;
require_once __DIR__ . '\..\..\..\../vendor/autoload.php';



use iutnc\deefy\audio\action\{
    DefaultAction,
    DisplayPlaylist,
    AddPlaylist,
    AddPodcastTrackAction,
    AddAudio,
    AddUserAction
};

class Dispatcher {

    private string $action;

    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void {
        switch ($this->action) {
            case 'playlist':
                $action = new DisplayPlaylist();
                break;
            case 'add-playlist':
                $action = new AddPlaylist();
                break;
            case 'add-track':
                $action = new AddPodcastTrackAction();
                break;
            case 'add-user':
                $action = new AddUserAction();
                break;
            case 'add-audio':
                $action = new AddAudio();
                break;
            default:
                $action = new DefaultAction();
                break;
        }

        $html = $action->execute();

        $this->renderPage($html);
    }

    private function renderPage(string $html): void {
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>DeefyApp</title>
        </head>
        <body>
            <nav>
                <a href="?action=default">Accueil</a> |
                <a href="?action=add-playlist">Créer Playlist</a> |
                <a href="?action=add-audio">Ajouter Track</a> |
                <a href="?action=playlist">Voir Playlist</a> |
                <a href="?action=add-audio">Ajouter un audio</a> |
                <a href="?action=add-user">Ajouter un utilisateur</a> 
            </nav>
            <hr>
            $html
        </body>
        </html>
        HTML;
    }
}
