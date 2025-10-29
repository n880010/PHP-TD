<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;

require_once __DIR__ . '/../../../../vendor/autoload.php';

use iutnc\deefy\audio\action\{
    DefaultAction,
    DisplayPlaylist,
    AddPlaylist,
    AddPodcastTrackAction,
    AddAudio,
    SigninAction,
    RegisterAction,
    AddUserAction
};

class Dispatcher {

    private string $action;

    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void {
        session_start();

        // Actions qui demandent d'être connecté
        $restrictedActions = ['add-playlist', 'add-track', 'add-audio', 'playlist', 'add-user'];

        if (in_array($this->action, $restrictedActions) && empty($_SESSION['user'])) {
            $this->renderPage("<p style='color:red'>Vous devez être connecté pour accéder à cette page.</p>");
            return;
        }

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
            case 'add-audio':
                $action = new AddAudio();
                break;
            case 'signin':
                $action = new SigninAction();
                break;
            case 'register':
                $action = new RegisterAction();
                break;
            case 'add-user':
                $action = new AddUserAction();
                break;
            default:
                $action = new DefaultAction();
                break;
        }

        $html = $action->execute();
        $this->renderPage($html);
    }

    private function renderPage(string $html): void {
        $nav = '<a href="?action=default">Accueil</a> | ';

        if (!empty($_SESSION['user'])) {
            $nav .= '<a href="?action=add-playlist">Créer Playlist</a> | ';
            $nav .= '<a href="?action=add-audio">Ajouter Track</a> | ';
            $nav .= '<a href="?action=playlist">Voir Playlist</a> | ';
            $nav .= '<a href="?action=add-user">Ajouter un utilisateur</a> ';
        }
        else{
        $nav .= '<a href="?action=signin">Connexion</a> | ';
        $nav .= '<a href="?action=register">Inscription</a>';}

        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>DeefyApp</title>
        </head>
        <body>
            <nav>
                $nav
            </nav>
            <hr>
            $html
        </body>
        </html>
        HTML;
    }
}
