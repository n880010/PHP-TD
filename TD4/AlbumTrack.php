<?php
declare(strict_types=1);

require_once 'AudioTrack.php';

class AlbumTrack extends AudioTrack {
    // Attributs privés spécifiques à AlbumTrack
    public string $album;
    public int $annee;
    public int $num_piste;

    public function __construct(
        string $titre,
        string $nom_fichier_audio,
        string $artiste,
        int $duree,
        string $genre
    ) {
        // Initialise les attributs hérités
        parent::__construct($titre, $nom_fichier_audio, $artiste, $duree, $genre);

        // Valeurs par défaut
        $this->album = 'Inconnu';
        $this->annee = 2025;
        $this->num_piste = 0;
    }

    public function __toString(): string {
        // Retourne toutes les propriétés privées (de la classe enfant seulement)
        return json_encode(get_object_vars($this), JSON_PRETTY_PRINT);
    }
}
