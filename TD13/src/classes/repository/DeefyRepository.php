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

        $host = self::$config['host'];
        $dbname = self::$config['dbname'];
        $user = self::$config['user'];
        $password = self::$config['password'];
        
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

        try {
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            throw new \Exception("Erreur de connexion : " . $e->getMessage());
        }
    }


    public function getPDO(): PDO {
    return $this->pdo;
}

    public static function setConfig(string $file): void {
        if (!file_exists($file)) {
            throw new \Exception("Fichier de config introuvable : $file");
        }
        self::$config = parse_ini_file($file);
    }

    public static function getInstance(): DeefyRepository {
        if (self::$instance === null) {
            self::$instance = new DeefyRepository();
        }
        return self::$instance;
    }

    // --- MÉTHODES DU TD13 ---

    public function findAllPlaylists(): array {
        $stmt = $this->pdo->query("SELECT * FROM playlist");
        return $stmt->fetchAll();
    }

    public function saveEmptyPlaylist(string $name): int {
        $stmt = $this->pdo->prepare("INSERT INTO playlist (nom) VALUES (?)");
        $stmt->execute([$name]);
        return (int) $this->pdo->lastInsertId();
    }

    public function savePodcastTrack(string $titre, string $genre, string $filename, string $type): int {
        $stmt = $this->pdo->prepare("INSERT INTO track (titre, genre, filename, type) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titre, $genre, $filename, $type]);
        return (int) $this->pdo->lastInsertId();
    }

    public function addTrackToPlaylist(int $playlist_id, int $track_id, int $no_piste): void {
        $stmt = $this->pdo->prepare("INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) VALUES (?, ?, ?)");
        $stmt->execute([$playlist_id, $track_id, $no_piste]);
    }

    public function findTracksByPlaylist(int $playlist_id): array {
        $sql = "SELECT t.* FROM track t 
                JOIN playlist2track p2t ON t.id = p2t.id_track 
                WHERE p2t.id_pl = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$playlist_id]);
        return $stmt->fetchAll();
    }
    
}
