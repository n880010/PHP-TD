<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;

require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

use iutnc\deefy\audio\action\Action;

class AddUserAction extends Action {

    public function execute(): string {

        // Si la requête est de type GET → on affiche le formulaire
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

        // Si la requête est de type POST → on traite le formulaire
        else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // On filtre les valeurs pour éviter les injections XSS
            $nom = filter_var($_POST['nom'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            $age = filter_var($_POST['age'] ?? '', FILTER_SANITIZE_NUMBER_INT);

            // Vérification minimale
            if (empty($nom) || empty($email) || empty($age)) {
                return "<p style='color:red;'>Veuillez remplir tous les champs.</p>";
            }

            // Message de confirmation
            return "<p>Nom : {$nom}, Email : {$email}, Âge : {$age} ans</p>";
        }

        // Sécurité : toute autre méthode HTTP est ignorée
        return "<p>Requête invalide.</p>";
    }
}
