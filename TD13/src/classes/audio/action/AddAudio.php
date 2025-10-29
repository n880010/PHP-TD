<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;

require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

use iutnc\deefy\audio\action\Action;

class AddAudio extends Action{

function handleUpload(): string {

    // Vérifie qu'un fichier a été envoyé
    if (!isset($_FILES['userfile']) || $_FILES['userfile']['error'] !== UPLOAD_ERR_OK) {
        return "<p style='color:red;'>Erreur pendant l'envoi du fichier.</p>";
    }

    $fichier = $_FILES['userfile'];

    // Vérifie que c'est bien un MP3
    if (substr($fichier['name'], -4) !== '.mp3' || $fichier['type'] !== 'audio/mpeg') {
        return "<p style='color:red;'>Le fichier doit être un MP3 valide.</p>";
    }

    // Crée un nom aléatoire pour éviter les doublons
    $nouveau_nom = uniqid('track_', true) . '.mp3';

    $destination = __DIR__ . '/../../audio/' . $nouveau_nom;

    // Déplace le fichier depuis le dossier temporaire vers /audio
    move_uploaded_file($fichier['tmp_name'], $destination);

    // Ajoute la piste dans la session
    $_SESSION['playlist'][] = $nouveau_nom;

    return "<p style='color:green;'>Fichier MP3 uploadé avec succès !</p>";
}


    function execute(): string {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        return <<<HTML
        <h2>Ajouter un fichier audio</h2>
        <form method="post" enctype="multipart/form-data" action="?action=add-audio">
            <label for="userfile">Choisir un fichier audio (.mp3) :</label><br>
            <input type="file" name="userfile" id="userfile" accept=".mp3,audio/mpeg" required><br><br>
            <button type="submit">Uploader</button>
        </form>
        HTML;
    }

    // --- POST ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        return $this->handleUpload();
    }

    
}
}