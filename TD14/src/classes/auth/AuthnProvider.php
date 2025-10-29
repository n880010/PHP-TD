<?php
declare(strict_types=1);

namespace iutnc\deefy\auth;

require_once __DIR__ . '/../../../vendor/autoload.php';
\iutnc\deefy\repository\DeefyRepository::setConfig(__DIR__ . '/../config/deefy.db.ini');

use iutnc\deefy\repository\DeefyRepository;

class AuthnException extends \Exception {}

class AuthnProvider {

    // --- SIGNIN ---
    public static function signin(string $email, string $password): array {
        $repo = DeefyRepository::getInstance();
        $pdo = $repo->getPDO(); 

        // Cherche l'utilisateur dans la table user
        $stmt = $pdo->prepare("SELECT * FROM User WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['passwd'])) {
            throw new AuthnException("Identifiants incorrects !");
        }

        // Connexion OK
        return $user; // retourne l'array de l'utilisateur
    }

    // --- REGISTER ---
    public static function register(string $email, string $password): int {
        $repo = DeefyRepository::getInstance();
        $pdo = $repo->getPDO(); // Récupère le PDO via le getter

        // Vérifie si l'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT id FROM User WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            throw new AuthnException("Un compte existe déjà avec cet email !");
        }

        // Vérifie la longueur du mot de passe
        if (strlen($password) < 10) {
            throw new AuthnException("Le mot de passe doit contenir au moins 10 caractères !");
        }

        // Hash du mot de passe
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare("INSERT INTO User (email, passwd, role) VALUES (?, ?, 1)");
        $stmt->execute([$email, $hash]);

        return (int)$pdo->lastInsertId();
    }
}
