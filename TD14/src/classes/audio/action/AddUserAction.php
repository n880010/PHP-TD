<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;

require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

use iutnc\deefy\audio\action\Action;

class AddUserAction extends Action {

    public function execute(): string {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return <<<HTML
            <h2>Inscription utilisateur</h2>
            <form method="post" action="?action=add-user">
                <label for="nom">Nom :</label><br>
                <input type="text" id="nom" name="nom" required><br><br>

                <label for="email">Email :</label><br>
                <input type="email" id="email" name="email" required><br><br>

                <label for="age">Âge :</label><br>
                <input type="number" id="age" name="age" min="1" max="120" required><br><br>

                <button type="submit">Connexion</button>
            </form>
            HTML;
        }

        else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // On filtre les valeurs pour éviter les injections XSS
            $nom = filter_var($_POST['nom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $age = filter_var($_POST['age'] ?? '', FILTER_SANITIZE_NUMBER_INT);

            if (empty($nom) || empty($email) || empty($age)) {
                return "<p style='color:red;'>Veuillez remplir tous les champs.</p>";
            }

            return "<p>Nom : {$nom}, Email : {$email}, Âge : {$age} ans</p>";
        }

        return "<p>Requête invalide.</p>";
    }
}
