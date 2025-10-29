<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;
require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\auth\AuthnException;
use iutnc\deefy\audio\action\Action;

class SigninAction extends Action {

    public function execute(): string {
        session_start();

        if ($this->http_method === 'POST') {
            $email = $_POST['email'] ?? '';
            $passwd = $_POST['passwd'] ?? '';

            try {
                $user = AuthnProvider::signin($email, $passwd);
                $_SESSION['user'] = $user;
                // pour éviter l'injection XSS
                return "<p>Connexion réussie ! Bonjour " . htmlspecialchars($email) . "</p>";
            } catch (AuthnException $e) {
                return "<p style='color:red'>" . $e->getMessage() . "</p>";
            }
        }

        // GET formulaire
        return <<<HTML
        <form method="post">
            <label>Email: <input type="email" name="email" required></label><br>
            <label>Mot de passe: <input type="password" name="passwd" required></label><br>
            <button type="submit">Se connecter</button>
        </form>
        HTML;
    }
}
