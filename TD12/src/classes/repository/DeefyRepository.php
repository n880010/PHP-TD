<?php
declare(strict_types=1);

namespace iutnc\deefy\repository;

use PDO;
use PDOException;

class DeefyRepository {

    private static ?array $config = null;

    private static ?DeefyRepository $instance = null;

    private PDO $pdo;

    private function __construct() {
        if (self::$config === null) {
            throw new \Exception("Configuration non définie. Appeler setConfig() avant getInstance().");
        }

        $host = self::$config['host'] ?? 'localhost';
        $dbname = self::$config['dbname'] ?? '';
        $user = self::$config['user'] ?? '';
        $password = self::$config['password'] ?? '';

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            throw new \Exception("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }


    public static function setConfig(string $file): void {
        if (!file_exists($file)) {
            throw new \Exception("Fichier de configuration introuvable : $file");
        }

        self::$config = parse_ini_file($file);
    }


    public static function getInstance(): DeefyRepository {
        if (self::$instance === null) {
            self::$instance = new DeefyRepository();
        }
        return self::$instance;
    }


    public function findPlaylistById(int $id): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM playlist WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

}
