<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;

require_once __DIR__ . '/../../../../vendor/autoload.php';

// Configuration du dépôt
\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '/../../config/deefy.db.ini');

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\audio\action\{
    DefaultAction,
    DisplayPlaylistAction,
    AddPlaylist,
    AddPodcastTrackAction,
    AddAudio,
    SigninAction,
    RegisterAction,
    AddUserAction
};

class Dispatcher {

    private string $action;
    // On recupere l'action en QUERY STRING , mais au début ya rien ducoup on considere que c'est default
    public function __construct() {
        $this->action = $_GET['action'] ?? 'default';
    }

    public function run(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Actions qui nécessitent une connexion
        $restrictedActions = ['add-playlist', 'add-track', 'add-audio', 'playlist', 'add-user'];
        
        // Si l'action qu'on a eu au début est dans les actions restreintes & qu'on est pas connecté alors on ne peut pas consulter la page
        if (in_array($this->action, $restrictedActions) && empty($_SESSION['user'])) {
            $this->renderPage("<p style='color:red'>Vous devez être connecté pour accéder à cette page.</p>");
            return;
        }

        // Sélection de l’action à exécuter
        switch ($this->action) {
            case 'display-playlist':
                $action = new DisplayPlaylistAction();
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
        // Menu de navigation avec l'action de base (accueil)
        $nav = '<a href="?action=default">Accueil</a> | ';

        // Si l'utilisateur est connecté
        if (!empty($_SESSION['user'])) {
            // Récupération du tableau utilisateur ( avec id , etc , les données necessaires récupérés dans SigninAction.php lorsque l'user s'est connecté)
            $user = $_SESSION['user'];
            // Création d'une connexion a la BDD
            $repo = DeefyRepository::getInstance();

            // Récupérer les playlist de l'utilisateur connecté
            $stmt = $repo->findPlaylistsByUserId([$user['id']]);
            $playlists = $stmt->fetchAll();

            // Menu utilisateur
            $nav .= '<a href="?action=add-playlist">Créer Playlist</a> | ';
            $nav .= '<a href="?action=add-audio">Ajouter Audio<a> | ';
            $nav .= '<a href="?action=add-track">Ajouter Track </a> | ';


            // Lister les playlists du user connecté
            foreach ($playlists as $pl) {
                $nav .= '<a href="?action=display-playlist&id=' . (int)$pl['id'] . '">' 
                        . htmlspecialchars($pl['nom']) . '</a> | ';
            }
            // Ajouter un utilisateur action
            $nav .= '<a href="?action=add-user">Ajouter un utilisateur</a> | ';
            // Action déconnexion ( pas encore ajouté )
            $nav .= '<a href="?action=logout">Déconnexion</a>';
        } else {
            // Menu invité
            $nav .= '<a href="?action=signin">Connexion</a> | ';
            $nav .= '<a href="?action=register">Inscription</a>';
        }

        // Affichage HTML
        echo <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>DeefyApp</title>
        </head>
        <body>
            <nav>$nav</nav>
            <hr>
            $html
        </body>
        </html>
        HTML;
    }
}
