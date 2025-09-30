<?php
declare(strict_types=1);
require_once 'Renderer.php';
require_once 'PodcastTrack.php';
require_once 'AudioTrackRenderer.php';

class PodcastTrackRenderer extends AudioTrackRenderer{
    public PodcastTrack $pod;

    public function __construct(PodcastTrack $pod) {
        $this->pod = $pod;
    }

    public function renderCompact(): string {
                return <<<HTML
<div class="podcast-track compact">
    <strong>{$this->pod->titre}</strong> - {$this->pod->artiste}
    <audio controls>
        <source src="{$this->pod->nom_fichier_audio}" type="audio/mpeg">
        Votre navigateur ne supporte pas la balise audio.
    </audio>
</div>
HTML;}

    public function renderLong():string{

                return <<<HTML
<div class="podcast-track long">
    <h2>{$this->pod->titre}</h2>
    <p>Artiste : {$this->pod->artiste}</p>
    <p>Nom émission : {$this->pod->nom_emission}</p>
    <p>Animateur : {$this->pod->animateur}</p>
    <p>Durée : {$this->pod->duree} secondes</p>
    <p>Genre : {$this->pod->genre}</p>
    <audio controls>
        <source src="{$this->pod->nom_fichier_audio}" type="audio/mpeg">
        Votre navigateur ne supporte pas la balise audio.
    </audio>
</div>
HTML;
        
    }

}
