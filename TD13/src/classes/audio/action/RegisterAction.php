<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\action;
require_once __DIR__ . '\..\..\..\../vendor/autoload.php';

use iutnc\deefy\auth\AuthnProvider;
use iutnc\deefy\auth\AuthnException;
use iutnc\deefy\audio\action\Action;

class RegisterAction extends Action {

    public function execute(): string {
        session_start();

        if ($this->http_method === 'POST') {
            $email = $_POST['email'] ?? '';
            $passwd1 = $_POST['passwd1'] ?? '';
            $passwd2 = $_POST['passwd2'] ?? '';

            if ($passwd1 !== $passwd2) {
                return "<p style='color:red'>Les mots de passe ne correspondent pas !</p>";
            }

            try {
                $id = AuthnProvider::register($email, $passwd1);
                return "<p>Inscription réussie ! ID utilisateur : $id</p>";
            } catch (AuthnException $e) {
                return "<p style='color:red'>" . $e->getMessage() . "</p>";
            }
        }

        // GET formulaire
        return <<<HTML
        <form method="post">
            <label>Email: <input type="email" name="email" required></label><br>
            <label>Mot de passe: <input type="password" name="passwd1" required></label><br>
            <label>Confirmer mot de passe: <input type="password" name="passwd2" required></label><br>
            <button type="submit">S'inscrire</button>
        </form>
        HTML;
    }
}
