<?php
require_once 'AudioTrack.php';

class PodcastTrack extends AudioTrack{
    public string $nom_emission;
    public string $animateur;

    public function __construct(string $titre,string $nom_fichier_audio,string $nom_emission,string $animateur, string $artiste = "",int $duree = 0,string $genre = ""){
        parent::__construct($titre,$nom_fichier_audio,$artiste,$duree,$genre);
        $this->nom_emission = $nom_emission;
        $this->animateur = $animateur;
    }
    public function __toString():string{
        return json_encode(get_object_vars($this));
    }
    
}