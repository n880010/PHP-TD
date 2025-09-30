<?php
declare(strict_types=1);

class AudioTrack {
    public string $titre;
    public string $artiste;
    public int $duree;
    public string $nom_fichier_audio;
    public string $genre;

    // Constructeur
    public function __construct(
        string $titre,
        string $nom_fichier_audio,
        string $artiste = "",
        int $duree = 0,
        string $genre = ""
    ) {
        $this->titre = $titre;
        $this->nom_fichier_audio = $nom_fichier_audio;
        $this->artiste = $artiste;
        $this->duree = $duree;
        $this->genre = $genre;
    }

    // Méthode pour afficher l'objet en JSON
    public function __toString(): string {
        return json_encode(get_object_vars($this));
    }
}
